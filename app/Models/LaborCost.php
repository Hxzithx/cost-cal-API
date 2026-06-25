<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\SyncsIsDeleteFlag;

class LaborCost extends Model
{
    use SoftDeletes, SyncsIsDeleteFlag;

    protected $table = 'labor_costs';

    protected $fillable = [
        'dish_id',
        'role_name',
        'monthly_salary',
        'monthly_hours',
        'prep_time_minutes',
        'data',
        'is_delete',
    ];

    protected $casts = [
        'monthly_salary' => 'decimal:2',
        'monthly_hours' => 'decimal:2',
        'prep_time_minutes' => 'decimal:2',
        'data' => 'array',
    ];

    protected $appends = ['hourly_rate', 'cost_per_portion'];

    protected static function booted(): void
    {
        static::creating(function ($labor) {
            $labor->data = self::buildData($labor);
        });

        static::updating(function ($labor) {
            $labor->data = self::buildData($labor);
        });
    }

    private static function buildData($labor): array
    {
        return [
            'dish_id' => $labor->dish_id,
            'role_name' => $labor->role_name,
            'monthly_salary' => $labor->monthly_salary,
            'monthly_hours' => $labor->monthly_hours,
            'prep_time_minutes' => $labor->prep_time_minutes,
        ];
    }

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