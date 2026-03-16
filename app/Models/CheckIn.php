<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CheckIn extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'ticket_id',
        'checked_in_by_user_id',
        'checked_in_at',
        'is_manual_override',
        'override_reason',
    ];

    protected $casts = [
        'checked_in_at' => 'datetime',
        'is_manual_override' => 'boolean',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function checkedInBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'checked_in_by_user_id');
    }
}
