<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Webhook extends Model
{
    protected $fillable = [
        'name',
        'url',
        'event',
        'headers',
        'is_active',
    ];

    protected $casts = [
        'headers' => 'array',
        'is_active' => 'boolean',
    ];
}
