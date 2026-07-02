<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Seeder;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $setting = [
            'currency_symbol' => 'Rs.',
            'default_wastage_margin' => 0,
            'standard_labor_hours_per_month' => 208,
            'pricing_calculation_method' => 'margin',
            'target_gross_margin' => 70,
        ];

        $model = SystemSetting::firstOrCreate(['id' => 1], $setting);

        $attributes = $model->getAttributes();
        unset($attributes['created_at'], $attributes['updated_at'], $attributes['deleted_at']);

        $model->updateQuietly(['data' => $attributes]);
    }
}