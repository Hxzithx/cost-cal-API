<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ingredients = [
            ['name' => 'Basmati Rice', 'external_id' => 'ING-RICE-01', 'description' => 'Premium quality aged long-grain rice.', 'stock_qty' => 150, 'min_level_qty' => 20, 'cost_per_unit' => 200.00, 'supplier_name' => 'Heritage Grains', 'is_active' => true],
            ['name' => 'Eggs', 'external_id' => 'ING-EGG-02', 'is_active' => true],
            ['name' => 'Soy Sauce', 'external_id' => 'ING-SOY-03', 'is_active' => true],
            ['name' => 'Raw Chicken', 'external_id' => 'ING-CHICK-04', 'is_active' => true],
            ['name' => 'Vegetable Oil', 'external_id' => 'ING-OIL-05', 'is_active' => true],
            ['name' => 'Salt', 'external_id' => 'ING-SALT-06', 'is_active' => true],
            ['name' => 'Black Pepper', 'external_id' => 'ING-PEP-07', 'is_active' => true],
            ['name' => 'Garlic', 'external_id' => 'ING-GAR-08', 'is_active' => true],
            ['name' => 'Onion', 'external_id' => 'ING-ONION-09', 'is_active' => true],
        ];

        foreach ($ingredients as $ingredient) {
            Ingredient::create($ingredient);
        }
    }
}