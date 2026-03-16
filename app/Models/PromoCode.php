<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PromoCode extends Model
{
    public const TYPE_FIXED = 'fixed';
    public const TYPE_PERCENT = 'percent';

    protected $fillable = [
        'event_id',
        'code',
        'discount_type',
        'discount_value',
        'max_uses',
        'used_count',
        'is_active',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
