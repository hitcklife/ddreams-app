<?php

namespace App\Livewire;

use App\Models\AutoBid;
use App\Services\AmazonApiService;
use App\Services\BidService;
use Livewire\Attributes\Layout;
use Livewire\Component;

class AmazonAuctions extends Component
{
    public $showFilters = false;
    public $auctions = [];
    public $loading = false;
    public $error = null;
    public $showDetailsModal = false;
    public $selectedAuction = null;
    public $selectedAuctionIndex = null;
    public $showBidModal = false;
    public $bidAmount = '';
    public $calculatedPerMile = 0;
    public $showAutoBidModal = false;
    public $autoBidMinPrice = '';
    public $autoBidCalculatedPerMile = 0;

    // Filter properties
    public $programs = ['THIRD_PARTY_ONE_WAY', 'YARD_HOSTLING'];
    public $contractStartDate = '';
    public $contractEndDate = '';
    public $locationType = 'Node to Node';
    public $equipmentType = 'FIFTY_THREE_FOOT_TRUCK';
    public $originCity = 'Anywhere';
    public $originLat = null;
    public $originLng = null;
    public $originRadius = null;
    public $destinationCity = 'Anywhere';
    public $destinationLat = null;
    public $destinationLng = null;
    public $destinationRadius = null;
    public $showBidAuctions = false;
    public $sortOption = 'AUCTION_CLOSING_TIME';
    public $sortDirection = 'ASC';
    public $paginationStart = 0;
    public $paginationEnd = 49;

    protected $rules = [
        'originLat' => 'nullable|numeric|between:-90,90',
        'originLng' => 'nullable|numeric|between:-180,180',
        'originRadius' => 'nullable|integer|min:1',
        'destinationLat' => 'nullable|numeric|between:-90,90',
        'destinationLng' => 'nullable|numeric|between:-180,180',
        'destinationRadius' => 'nullable|integer|min:1',
        'paginationStart' => 'required|integer|min:0',
        'paginationEnd' => 'required|integer|min:1',
    ];

    public function mount()
    {
        $this->loadAuctions();
    }

    public function toggleFilters()
    {
        $this->showFilters = !$this->showFilters;
        
        // Emit event to JavaScript when filters are shown
        if ($this->showFilters) {
            $this->dispatch('filters-shown');
        }
    }

    public function applyFilters()
    {
        $this->validate();
        $this->loadAuctions();
        $this->showFilters = false;
    }

    public function resetFilters()
    {
        $this->programs = ['THIRD_PARTY_ONE_WAY', 'YARD_HOSTLING'];
        $this->contractStartDate = '';
        $this->contractEndDate = '';
        $this->locationType = 'Node to Node';
        $this->equipmentType = 'FIFTY_THREE_FOOT_TRUCK';
        $this->originCity = 'Anywhere';
        $this->originLat = null;
        $this->originLng = null;
        $this->originRadius = null;
        $this->destinationCity = 'Anywhere';
        $this->destinationLat = null;
        $this->destinationLng = null;
        $this->destinationRadius = null;
        $this->showBidAuctions = false;
        $this->sortOption = 'AUCTION_CLOSING_TIME';
        $this->sortDirection = 'ASC';
        $this->paginationStart = 0;
        $this->paginationEnd = 49;
        
        $this->loadAuctions();
    }

    public function loadAuctions()
    {
        $this->loading = true;
        $this->error = null;

        try {
            $apiService = AmazonApiService::createForUser(auth()->id());
            
            if (!$apiService) {
                $this->error = 'Amazon settings not configured. Please configure your settings first.';
                $this->loading = false;
                return;
            }

            $filterOptions = [
                'programs' => $this->programs,
                'filterOptions' => [
                    'contractStartDate' => $this->contractStartDate ?: null,
                    'contractEndDate' => $this->contractEndDate ?: null,
                    'originRadiusFilter' => ($this->originLat && $this->originLng && $this->originRadius) ? [
                        'radiusInMeters' => (int)($this->originRadius * 1609.34), // Convert miles to meters
                        'geoLocation' => [
                            'latitude' => (float)$this->originLat,
                            'longitude' => (float)$this->originLng
                        ]
                    ] : null,
                    'destinationRadiusFilter' => ($this->destinationLat && $this->destinationLng && $this->destinationRadius) ? [
                        'radiusInMeters' => (int)($this->destinationRadius * 1609.34),
                        'geoLocation' => [
                            'latitude' => (float)$this->destinationLat,
                            'longitude' => (float)$this->destinationLng
                        ]
                    ] : null,
                    'hideBidAuctions' => !$this->showBidAuctions,
                    'showBidAuctions' => $this->showBidAuctions,
                    'locationTypes' => [],
                    'intermodalTypes' => [],
                    'equipmentTypes' => [$this->equipmentType],
                    'equipmentCategory' => null,
                    'deliveryLocationSearchFilter' => null
                ],
                'sortOptions' => [
                    'option' => $this->sortOption,
                    'direction' => $this->sortDirection
                ],
                'paginationStart' => (int)$this->paginationStart,
                'paginationEnd' => (int)$this->paginationEnd
            ];

            \Log::info('Livewire Filter Options', [
                'originLat' => $this->originLat,
                'originLng' => $this->originLng,
                'originRadius' => $this->originRadius,
                'destinationLat' => $this->destinationLat,
                'destinationLng' => $this->destinationLng,
                'destinationRadius' => $this->destinationRadius,
                'filterOptions' => $filterOptions
            ]);

            $response = $apiService->fetchLiveAuctions($filterOptions);
            
            if ($response) {
                $this->auctions = $response['bidderAuctionDetailsList'] ?? [];
            } else {
                $this->error = 'Failed to fetch auctions. Please check your Amazon settings.';
            }
        } catch (\Exception $e) {
            $this->error = 'Error: ' . $e->getMessage();
        }

        $this->loading = false;
    }

    public function updateOriginLocation($placeId, $description, $lat, $lng)
    {
        $this->originCity = $description;
        $this->originLat = $lat;
        $this->originLng = $lng;
        $this->originRadius = $this->originRadius ?: 250; // Set default radius when origin is selected
        
        // Auto-apply filters when location is selected
        $this->loadAuctions();
    }

    public function updateDestinationLocation($placeId, $description, $lat, $lng)
    {
        $this->destinationCity = $description;
        $this->destinationLat = $lat;
        $this->destinationLng = $lng;
        $this->destinationRadius = $this->destinationRadius ?: 250; // Set default radius when destination is selected
        
        // Auto-apply filters when location is selected
        $this->loadAuctions();
    }

    public function showDetails($auctionIndex)
    {
        if (isset($this->auctions[$auctionIndex])) {
            $this->selectedAuction = $this->auctions[$auctionIndex];
            $this->selectedAuctionIndex = $auctionIndex;
            $this->showDetailsModal = true;
        }
    }

    public function closeDetailsModal()
    {
        $this->showDetailsModal = false;
        $this->selectedAuction = null;
        $this->selectedAuctionIndex = null;
    }

    public function openBidModal($auctionIndex)
    {
        if (isset($this->auctions[$auctionIndex])) {
            $this->selectedAuction = $this->auctions[$auctionIndex];
            $this->selectedAuctionIndex = $auctionIndex;
            $this->showBidModal = true;
            $this->bidAmount = '';
            $this->calculatedPerMile = 0;
            $this->showDetailsModal = false; // Close details modal if open
        }
    }

    public function closeBidModal()
    {
        $this->showBidModal = false;
        $this->selectedAuction = null;
        $this->selectedAuctionIndex = null;
        $this->bidAmount = '';
        $this->calculatedPerMile = 0;
    }

    public function openAutoBidModal($auctionIndex)
    {
        if (isset($this->auctions[$auctionIndex])) {
            $this->selectedAuction = $this->auctions[$auctionIndex];
            $this->selectedAuctionIndex = $auctionIndex;
            $this->showAutoBidModal = true;
            $this->autoBidMinPrice = '';
            $this->autoBidCalculatedPerMile = 0;
            $this->showDetailsModal = false; // Close details modal if open
            $this->showBidModal = false; // Close bid modal if open
        }
    }

    public function closeAutoBidModal()
    {
        $this->showAutoBidModal = false;
        $this->selectedAuction = null;
        $this->selectedAuctionIndex = null;
        $this->autoBidMinPrice = '';
        $this->autoBidCalculatedPerMile = 0;
    }

    public function updatedAutoBidMinPrice()
    {
        $this->calculateAutoBidPerMile();
    }

    public function calculateAutoBidPerMile()
    {
        if (!$this->selectedAuction || !$this->autoBidMinPrice || !is_numeric($this->autoBidMinPrice)) {
            $this->autoBidCalculatedPerMile = 0;
            return;
        }

        // Get route information to calculate distance
        $auctionView = $this->selectedAuction['auctionView'];
        $stops = $auctionView['item']['regionList'][0]['stops'] ?? [];
        $origin = $stops[0] ?? null;
        $destination = $stops[1] ?? null;

        if (!$origin || !$destination) {
            $this->autoBidCalculatedPerMile = 0;
            return;
        }

        // Calculate distance using Haversine formula
        $originLat = $origin['address']['latitude'] ?? 0;
        $originLng = $origin['address']['longitude'] ?? 0;
        $destLat = $destination['address']['latitude'] ?? 0;
        $destLng = $destination['address']['longitude'] ?? 0;

        if ($originLat && $originLng && $destLat && $destLng) {
            $distance = $this->calculateDistance($originLat, $originLng, $destLat, $destLng);
            if ($distance > 0) {
                $this->autoBidCalculatedPerMile = round((float)$this->autoBidMinPrice / $distance, 2);
            } else {
                $this->autoBidCalculatedPerMile = 0;
            }
        } else {
            $this->autoBidCalculatedPerMile = 0;
        }
    }

    public function setupAutoBid()
    {
        if (!$this->autoBidMinPrice || !is_numeric($this->autoBidMinPrice) || $this->autoBidMinPrice <= 0) {
            session()->flash('error', 'Please enter a valid minimum bid price.');
            return;
        }

        if (!$this->selectedAuction) {
            session()->flash('error', 'No auction selected.');
            return;
        }

        $auctionView = $this->selectedAuction['auctionView'];
        $auctionId = $auctionView['auctionId'];
        $closingTime = $auctionView['closingTime'];

        // Check if auto-bid already exists for this auction
        $existingAutoBid = AutoBid::where('user_id', auth()->id())
            ->where('auction_id', $auctionId)
            ->where('is_active', true)
            ->first();

        if ($existingAutoBid) {
            // Update existing auto-bid
            $existingAutoBid->update([
                'minimum_bid_price' => $this->autoBidMinPrice,
                'auction_data' => $this->selectedAuction,
            ]);
            session()->flash('success', 'Auto-bid updated successfully! Minimum price: $' . number_format($this->autoBidMinPrice));
        } else {
            // Create new auto-bid
            AutoBid::create([
                'user_id' => auth()->id(),
                'auction_id' => $auctionId,
                'minimum_bid_price' => $this->autoBidMinPrice,
                'auction_closing_time' => \Carbon\Carbon::createFromTimestamp($closingTime),
                'auction_data' => $this->selectedAuction,
            ]);
            session()->flash('success', 'Auto-bid setup successfully! Minimum price: $' . number_format($this->autoBidMinPrice));
        }

        $this->closeAutoBidModal();
    }

    public function updatedBidAmount()
    {
        $this->calculatePerMile();
    }

    public function calculatePerMile()
    {
        if (!$this->selectedAuction || !$this->bidAmount || !is_numeric($this->bidAmount)) {
            $this->calculatedPerMile = 0;
            return;
        }

        // Get route information to calculate distance
        $auctionView = $this->selectedAuction['auctionView'];
        $stops = $auctionView['item']['regionList'][0]['stops'] ?? [];
        $origin = $stops[0] ?? null;
        $destination = $stops[1] ?? null;

        if (!$origin || !$destination) {
            $this->calculatedPerMile = 0;
            return;
        }

        // Calculate distance using Haversine formula
        $originLat = $origin['address']['latitude'] ?? 0;
        $originLng = $origin['address']['longitude'] ?? 0;
        $destLat = $destination['address']['latitude'] ?? 0;
        $destLng = $destination['address']['longitude'] ?? 0;

        if ($originLat && $originLng && $destLat && $destLng) {
            $distance = $this->calculateDistance($originLat, $originLng, $destLat, $destLng);
            if ($distance > 0) {
                $this->calculatedPerMile = round((float)$this->bidAmount / $distance, 2);
            } else {
                $this->calculatedPerMile = 0;
            }
        } else {
            $this->calculatedPerMile = 0;
        }
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 3959; // miles

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));

        return $earthRadius * $c;
    }

    public function submitBid()
    {
        if (!$this->bidAmount || !is_numeric($this->bidAmount) || $this->bidAmount <= 0) {
            session()->flash('error', 'Please enter a valid bid amount.');
            return;
        }

        if (!$this->selectedAuction) {
            session()->flash('error', 'No auction selected.');
            return;
        }

        try {
            $bidService = BidService::createForUser(auth()->id());
            
            if (!$bidService) {
                session()->flash('error', 'Amazon settings not configured. Please configure your settings first.');
                return;
            }

            $auctionView = $this->selectedAuction['auctionView'];
            $auctionId = $auctionView['auctionId'];
            
            $success = $bidService->submitBid($auctionId, (float)$this->bidAmount);
            
            if ($success) {
                // Update any existing auto-bids with this bid amount
                AutoBid::where('user_id', auth()->id())
                    ->where('auction_id', $auctionId)
                    ->where('is_active', true)
                    ->update(['last_bid_amount' => $this->bidAmount]);

                session()->flash('success', 'Bid submitted successfully for $' . number_format($this->bidAmount) . '!');
                $this->loadAuctions(); // Refresh auctions to show updated bid status
            } else {
                session()->flash('error', 'Failed to submit bid. Please try again.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error submitting bid: ' . $e->getMessage());
        }

        $this->closeBidModal();
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.amazon-auctions');
    }
}
