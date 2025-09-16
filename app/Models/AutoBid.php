<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AutoBid extends Model
{
    protected $fillable = [
        'user_id',
        'auction_id',
        'minimum_bid_price',
        'last_bid_amount',
        'auction_closing_time',
        'is_active',
        'is_executed',
        'executed_at',
        'auction_data',
    ];

    protected $casts = [
        'minimum_bid_price' => 'decimal:2',
        'last_bid_amount' => 'decimal:2',
        'auction_closing_time' => 'datetime',
        'is_active' => 'boolean',
        'is_executed' => 'boolean',
        'executed_at' => 'datetime',
        'auction_data' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->where('is_executed', false);
    }

    public function scopeReadyForExecution($query)
    {
        return $query->active()
            ->where('auction_closing_time', '>', now())
            ->where('auction_closing_time', '<=', now()->addMinute());
    }
}
