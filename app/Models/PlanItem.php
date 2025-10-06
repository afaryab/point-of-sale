<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class PlanItem extends Model
{
    protected $fillable = [
        'plan_id',
        'itemable_type',
        'itemable_id',
        'quantity',
    ];

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function itemable(): MorphTo
    {
        return $this->morphTo();
    }
}
