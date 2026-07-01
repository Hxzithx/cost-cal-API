<?php

namespace Database\Seeders;

use App\Models\Dish;
use App\Models\LaborCost;
use Illuminate\Database\Seeder;

class LaborCostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $friedRice = Dish::where('name', 'Chicken Fried Rice')->first();
        if (!$friedRice) {
            return;
        }

        $laborCosts = [
            [
                'dish_id' => $friedRice->id,
                'role_name' => 'Head Chef',
                'monthly_salary' => 6000.00,
                'monthly_hours' => 160.00,
                'prep_time_minutes' => 10.00,
            ],
            [
                'dish_id' => $friedRice->id,
                'role_name' => 'Kitchen Assistant',
                'monthly_salary' => 3000.00,
                'monthly_hours' => 160.00,
                'prep_time_minutes' => 15.00,
            ],
        ];

        foreach ($laborCosts as $laborCost) {
            // Create the labor cost record
            $model = LaborCost::create($laborCost);

            // Build snapshot of attributes
            $attributes = $model->getAttributes();
            unset($attributes['created_at'], $attributes['updated_at'], $attributes['deleted_at']);

            // Backfill the data column explicitly
            $model->updateQuietly(['data' => $attributes]);
        }
    }
}
