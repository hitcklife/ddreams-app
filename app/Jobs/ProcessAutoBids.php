<?php

namespace App\Jobs;

use App\Models\AutoBid;
use App\Services\AmazonApiService;
use App\Services\BidService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ProcessAutoBids implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('Starting auto-bid processing');

        // Get all auto-bids that are ready for execution (closing within next minute)
        $autoBids = AutoBid::readyForExecution()->with('user')->get();

        Log::info('Found auto-bids ready for processing', ['count' => $autoBids->count()]);

        foreach ($autoBids as $autoBid) {
            $this->processAutoBid($autoBid);
        }

        Log::info('Completed auto-bid processing');
    }

    private function processAutoBid(AutoBid $autoBid): void
    {
        Log::info('Processing auto-bid', [
            'autoBidId' => $autoBid->id,
            'auctionId' => $autoBid->auction_id,
            'userId' => $autoBid->user_id
        ]);

        try {
            // Check if we're within 5 seconds of closing time
            $closingTime = $autoBid->auction_closing_time;
            $now = now();
            $secondsUntilClose = $closingTime->diffInSeconds($now, false);

            // Only execute if we're within 5 seconds of closing
            if ($secondsUntilClose > 5) {
                Log::info('Auto-bid not ready for execution yet', [
                    'autoBidId' => $autoBid->id,
                    'secondsUntilClose' => $secondsUntilClose
                ]);
                return;
            }

            // Get current auction data
            $apiService = AmazonApiService::createForUser($autoBid->user_id);
            if (!$apiService) {
                Log::error('Cannot create API service for user', ['userId' => $autoBid->user_id]);
                return;
            }

            // Fetch current auction data to check latest bids
            $response = $apiService->fetchLiveAuctions([
                'programs' => ['THIRD_PARTY_ONE_WAY', 'YARD_HOSTLING'],
                'filterOptions' => [
                    'hideBidAuctions' => false,
                    'showBidAuctions' => true,
                    'equipmentTypes' => ['FIFTY_THREE_FOOT_TRUCK']
                ],
                'paginationStart' => 0,
                'paginationEnd' => 1000 // Get more results to find our specific auction
            ]);

            if (!$response || empty($response['bidderAuctionDetailsList'])) {
                Log::error('Failed to fetch auction data', ['autoBidId' => $autoBid->id]);
                return;
            }

            // Find the specific auction we're bidding on
            $targetAuction = collect($response['bidderAuctionDetailsList'])
                ->first(function ($auction) use ($autoBid) {
                    return $auction['auctionView']['auctionId'] === $autoBid->auction_id;
                });

            if (!$targetAuction) {
                Log::error('Target auction not found', [
                    'autoBidId' => $autoBid->id,
                    'auctionId' => $autoBid->auction_id
                ]);
                // Mark as executed to prevent further attempts
                $autoBid->update(['is_executed' => true, 'executed_at' => now()]);
                return;
            }

            // Calculate competitive bid
            $bidService = BidService::createForUser($autoBid->user_id);
            if (!$bidService) {
                Log::error('Cannot create bid service for user', ['userId' => $autoBid->user_id]);
                return;
            }

            $competitiveBid = $bidService->calculateCompetitiveBid($targetAuction, $autoBid);
            
            if ($competitiveBid === null) {
                Log::info('No competitive bid calculated, skipping', ['autoBidId' => $autoBid->id]);
                $autoBid->update(['is_executed' => true, 'executed_at' => now()]);
                return;
            }

            // Submit the bid
            $success = $bidService->submitBid($autoBid->auction_id, $competitiveBid);

            if ($success) {
                Log::info('Auto-bid submitted successfully', [
                    'autoBidId' => $autoBid->id,
                    'auctionId' => $autoBid->auction_id,
                    'bidAmount' => $competitiveBid
                ]);

                // Update the auto-bid record
                $autoBid->update([
                    'last_bid_amount' => $competitiveBid,
                    'is_executed' => true,
                    'executed_at' => now()
                ]);
            } else {
                Log::error('Auto-bid submission failed', [
                    'autoBidId' => $autoBid->id,
                    'auctionId' => $autoBid->auction_id,
                    'bidAmount' => $competitiveBid
                ]);
                
                // Mark as executed to prevent retries
                $autoBid->update(['is_executed' => true, 'executed_at' => now()]);
            }

        } catch (\Exception $e) {
            Log::error('Error processing auto-bid', [
                'autoBidId' => $autoBid->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Mark as executed to prevent infinite retries
            $autoBid->update(['is_executed' => true, 'executed_at' => now()]);
        }
    }
}
