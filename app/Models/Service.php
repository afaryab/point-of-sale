<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'duration',
        'requires_provider',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'requires_provider' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function planItems()
    {
        return $this->morphMany(PlanItem::class, 'itemable');
    }

    public function billItems()
    {
        return $this->morphMany(BillItem::class, 'itemable');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
