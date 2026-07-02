<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    protected $fillable = [
        'currency_symbol',
        'default_wastage_margin',
        'standard_labor_hours_per_month',
        'pricing_calculation_method',
        'target_gross_margin',
        'data',
    ];

    protected $casts = [
        'default_wastage_margin' => 'decimal:2',
        'standard_labor_hours_per_month' => 'decimal:2',
        'target_gross_margin' => 'decimal:2',
        'data' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function ($setting) {
            $setting->data = self::buildData($setting);
        });

        static::updating(function ($setting) {
            $setting->data = self::buildData($setting);
        });
    }

    public static function buildData($setting): array
    {
        return [
            'currency_symbol' => $setting->currency_symbol,
            'default_wastage_margin' => $setting->default_wastage_margin,
            'standard_labor_hours_per_month' => $setting->standard_labor_hours_per_month,
            'pricing_calculation_method' => $setting->pricing_calculation_method,
            'target_gross_margin' => $setting->target_gross_margin,
        ];
    }

    // Always return the single settings row, creating it with defaults if it doesn't exist yet
    public static function instance(): self
    {
        return self::firstOrCreate(
            ['id' => 1],
            [
                'currency_symbol' => 'Rs.',
                'default_wastage_margin' => 0,
                'standard_labor_hours_per_month' => 208,
                'pricing_calculation_method' => 'margin',
                'target_gross_margin' => 70,
            ]
        );
    }
}