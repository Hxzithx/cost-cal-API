<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OverheadCost extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'dish_id',
        'expense_name',
        'monthly_cost',
        'monthly_yield',
        'data',
    ];

    protected $casts = [
        'monthly_cost' => 'decimal:2',
        'monthly_yield' => 'decimal:2',
        'data' => 'array',
    ];

    protected $appends = ['cost_per_portion'];

    public function dish()
    {
        return $this->belongsTo(Dish::class);
    }

    public function getCostPerPortionAttribute(): ?float
    {
        if (!$this->monthly_yield || $this->monthly_yield == 0) {
            return null;
        }

        return round($this->monthly_cost / $this->monthly_yield, 2);
    }
}