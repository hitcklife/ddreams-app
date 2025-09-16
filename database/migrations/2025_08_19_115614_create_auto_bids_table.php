<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('auto_bids', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('auction_id');
            $table->decimal('minimum_bid_price', 10, 2);
            $table->decimal('last_bid_amount', 10, 2)->nullable();
            $table->timestamp('auction_closing_time');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_executed')->default(false);
            $table->timestamp('executed_at')->nullable();
            $table->json('auction_data')->nullable(); // Store auction details for reference
            $table->timestamps();
            
            $table->index(['user_id', 'auction_id']);
            $table->index(['is_active', 'auction_closing_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auto_bids');
    }
};
