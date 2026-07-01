<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Models\UnitConversion;
use Illuminate\Database\Seeder;

class UnitConversionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kg = Unit::where('symbol', 'Kg')->first();
        $g = Unit::where('symbol', 'g')->first();
        $l = Unit::where('symbol', 'L')->first();
        $ml = Unit::where('symbol', 'ml')->first();
        $dozen = Unit::where('symbol', 'Dozen')->first();
        $pcs = Unit::where('symbol', 'pcs')->first();

        // Helper closure to create + backfill
        $createWithData = function (array $fields) {
            $model = UnitConversion::create($fields);

            $attributes = $model->getAttributes();
            unset($attributes['created_at'], $attributes['updated_at'], $attributes['deleted_at']);

            $model->updateQuietly(['data' => $attributes]);
        };

        if ($kg && $g) {
            $createWithData([
                'parent_unit_id' => $kg->id,
                'child_unit_id' => $g->id,
                'factor' => 1000.0000,
            ]);
        }

        if ($l && $ml) {
            $createWithData([
                'parent_unit_id' => $l->id,
                'child_unit_id' => $ml->id,
                'factor' => 1000.0000,
            ]);
        }

        if ($dozen && $pcs) {
            $createWithData([
                'parent_unit_id' => $dozen->id,
                'child_unit_id' => $pcs->id,
                'factor' => 12.0000,
            ]);
        }
    }
}
