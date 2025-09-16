<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AmazonSetting extends Model
{
    protected $fillable = [
        'user_id',
        'amazon_email',
        'amazon_password',
        'anti_csrf_token_a2z',
        'cookie',
        'x_csrf_token',
        'access_token',
    ];

    protected $casts = [
        'amazon_email' => 'encrypted',
        'amazon_password' => 'encrypted',
        'anti_csrf_token_a2z' => 'encrypted',
        'cookie' => 'encrypted',
        'x_csrf_token' => 'encrypted',
        'access_token' => 'encrypted',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function hasAllSettings(): bool
    {
        return !empty($this->anti_csrf_token_a2z) &&
               !empty($this->cookie) &&
               !empty($this->x_csrf_token);
    }

    public function hasLoginCredentials(): bool
    {
        return !empty($this->amazon_email) && !empty($this->amazon_password);
    }
}
