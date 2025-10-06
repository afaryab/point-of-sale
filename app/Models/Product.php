<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
        'sku',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
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
}
