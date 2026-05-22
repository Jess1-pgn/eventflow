<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Ticket extends Model
{
    protected $fillable = [
        'order_item_id',
        'ticket_code',
        'holder_first_name',
        'holder_last_name',
        'holder_email',
        'holder_phone',
        'holder_national_id',
        'qr_payload_json',
        'qr_signature',
        'pdf_path',
    ];

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function checkIn(): HasOne
    {
        return $this->hasOne(CheckIn::class);
    }
}
