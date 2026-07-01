<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $heritageGrains = Supplier::where('name', 'Heritage Grains')->first();
        $meatMasters = Supplier::where('name', 'Meat Masters')->first();
        $cityGreens = Supplier::where('name', 'City Greens')->first();

        $ingredients = [
            ['name' => 'Basmati Rice', 'external_id' => 'ING-RICE-01', 'description' => 'Premium quality aged long-grain rice.', 'stock_qty' => 150, 'min_level_qty' => 20, 'cost_per_unit' => 200.00, 'supplier_id' => $heritageGrains?->id, 'is_active' => true],
            ['name' => 'Eggs', 'external_id' => 'ING-EGG-02', 'is_active' => true],
            ['name' => 'Soy Sauce', 'external_id' => 'ING-SOY-03', 'is_active' => true],
            ['name' => 'Raw Chicken', 'external_id' => 'ING-CHICK-04', 'is_active' => true],
            ['name' => 'Vegetable Oil', 'external_id' => 'ING-OIL-05', 'is_active' => true],
            ['name' => 'Salt', 'external_id' => 'ING-SALT-06', 'is_active' => true],
            ['name' => 'Black Pepper', 'external_id' => 'ING-PEP-07', 'is_active' => true],
            ['name' => 'Garlic', 'external_id' => 'ING-GAR-08', 'is_active' => true],
            ['name' => 'Onion', 'external_id' => 'ING-ONION-09', 'is_active' => true],
            ['name' => 'All-Purpose Flour', 'external_id' => 'ING-FLOUR-10', 'description' => 'Premium all-purpose flour.', 'stock_qty' => 30, 'min_level_qty' => 5, 'cost_per_unit' => 180.00, 'supplier_id' => $heritageGrains?->id, 'is_active' => true],
            ['name' => 'Beef Patty', 'external_id' => 'ING-BEEF-11', 'description' => 'Pre-formed beef burger patties.', 'stock_qty' => 15, 'min_level_qty' => 3, 'cost_per_unit' => 1100.00, 'supplier_id' => $meatMasters?->id, 'is_active' => true],
            ['name' => 'Bell Peppers', 'external_id' => 'ING-PEPPER-12', 'description' => 'Mixed green, red, and yellow bell peppers.', 'stock_qty' => 10, 'min_level_qty' => 2, 'cost_per_unit' => 200.00, 'supplier_id' => $cityGreens?->id, 'is_active' => true],
        ];

        foreach ($ingredients as $ingredient) {
            // Create the ingredient
            $model = Ingredient::create($ingredient);

            // Build snapshot of attributes
            $attributes = $model->getAttributes();
            unset($attributes['created_at'], $attributes['updated_at'], $attributes['deleted_at']);

            // Backfill the data column explicitly
            $model->updateQuietly(['data' => $attributes]);
        }
    }
}
