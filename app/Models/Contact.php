<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'address',
        'whatsapp',
        'phone',
        'email',
        'opening_hours',
        'maps_embed',
        'maps_url',
        'instagram',
        'facebook',
        'tiktok',
    ];
}
