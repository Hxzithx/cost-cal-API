<?php

namespace Database\Seeders;

use App\Models\Dish;
use App\Models\OverheadCost;
use Illuminate\Database\Seeder;

class OverheadCostSeeder extends Seeder
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

        $overheads = [
            [
                'dish_id' => $friedRice->id,
                'expense_name' => 'Electricity & Utilities',
                'monthly_cost' => 1000.00,
                'monthly_yield' => 2000.00,
            ],
            [
                'dish_id' => $friedRice->id,
                'expense_name' => 'Cooking Gas',
                'monthly_cost' => 1500.00,
                'monthly_yield' => 2000.00,
            ],
            [
                'dish_id' => $friedRice->id,
                'expense_name' => 'Kitchen Rent Share',
                'monthly_cost' => 5000.00,
                'monthly_yield' => 2000.00,
            ],
        ];

        foreach ($overheads as $overhead) {
            // Create the overhead cost record
            $model = OverheadCost::create($overhead);

            // Build snapshot of attributes
            $attributes = $model->getAttributes();
            unset($attributes['created_at'], $attributes['updated_at'], $attributes['deleted_at']);

            // Backfill the data column explicitly
            $model->updateQuietly(['data' => $attributes]);
        }
    }
}
