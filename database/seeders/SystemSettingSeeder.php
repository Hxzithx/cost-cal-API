<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Seeder;

class SystemSettingSeeder extends Seeder
{
    public function run(): void
    {
        SystemSetting::firstOrCreate(
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