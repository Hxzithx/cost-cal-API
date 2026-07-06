<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\SyncsIsDeleteFlag;

class OverheadCost extends Model
{
    use SoftDeletes, SyncsIsDeleteFlag;

    protected $table = 'overhead_costs';

    protected $fillable = [
        'dish_id',
        'expense_name',
        'monthly_cost',
        'monthly_yield',
        'data',
        'is_delete',
        'cost_type',
    ];

    protected $casts = [
        'monthly_cost' => 'decimal:2',
        'monthly_yield' => 'decimal:2',
        'data' => 'array',
    ];

    protected $appends = ['cost_per_portion'];

    protected static function booted(): void
    {
        static::creating(function ($overhead) {
            $overhead->data = self::buildData($overhead);
        });

        static::updating(function ($overhead) {
            $overhead->data = self::buildData($overhead);
        });
    }

    public static function buildData($overhead): array
    {
        return [
            'dish_id' => $overhead->dish_id,
            'expense_name' => $overhead->expense_name,
            'monthly_cost' => $overhead->monthly_cost,
            'monthly_yield' => $overhead->monthly_yield,
            'cost_type' => $overhead->cost_type,
        ];
    }

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

    const COST_TYPES = [
        'rent_lease' => 'Rent / Lease',
        'utilities' => 'Utilities',
        'fuel' => 'Fuel',
        'transport' => 'Transport',
        'equipment_machine' => 'Equipment / Machine',
        'insurance' => 'Insurance',
        'administration' => 'Administration',
        'maintenance' => 'Maintenance',
        'subcontract' => 'Subcontract',
        'finance_charges' => 'Finance Charges',
        'other' => 'Other',
    ];
}
