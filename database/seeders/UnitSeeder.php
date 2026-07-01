<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            ['name' => 'Kilogram', 'symbol' => 'Kg'],
            ['name' => 'Gram', 'symbol' => 'g'],
            ['name' => 'Liter', 'symbol' => 'L'],
            ['name' => 'Milliliter', 'symbol' => 'ml'],
            ['name' => 'Dozen', 'symbol' => 'Dozen'],
            ['name' => 'Pieces', 'symbol' => 'pcs'],
        ];

        foreach ($units as $unit) {
            // Create the unit
            $model = Unit::create($unit);

            // Build snapshot of attributes
            $attributes = $model->getAttributes();
            unset($attributes['created_at'], $attributes['updated_at'], $attributes['deleted_at']);

            // Backfill the data column explicitly
            $model->updateQuietly(['data' => $attributes]);
        }
    }
}
