<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    protected $fillable = [
        'name',
        'address_line1',
        'address_line2',
        'city',
        'region',
        'postal_code',
        'country',
        'lat',
        'lng',
    ];
}
