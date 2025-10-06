<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'gender',
        'relation_type',
        'relation_name',
        'phone',
        'cnic',
        'date_of_birth',
        'age',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function bills(): HasMany
    {
        return $this->hasMany(Bill::class);
    }
}
