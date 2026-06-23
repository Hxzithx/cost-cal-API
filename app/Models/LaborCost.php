<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LaborCost extends Model
{
    use SoftDeletes;

    protected $table = "labor_costs";
    protected $fillable = [
        'dish_id',
        'role_name',
        'monthly_salary',
        'monthly_hours',
        'prep_time_minutes',
        'data',
    ];

    protected $casts = [
        'monthly_salary' => 'decimal:2',
        'monthly_hours' => 'decimal:2',
        'prep_time_minutes' => 'decimal:2',
        'data' => 'array',
    ];

    protected $appends = ['hourly_rate', 'cost_per_portion'];

    public function dish()
    {
        return $this->belongsTo(Dish::class);
    }

    public function getHourlyRateAttribute(): ?float
    {
        if (!$this->monthly_hours || $this->monthly_hours == 0) {
            return null;
        }

        return round($this->monthly_salary / $this->monthly_hours, 2);
    }

    public function getCostPerPortionAttribute(): ?float
    {
        $hourlyRate = $this->getHourlyRateAttribute();

        if ($hourlyRate === null) {
            return null;
        }

        return round($hourlyRate * ($this->prep_time_minutes / 60), 2);
    }
}