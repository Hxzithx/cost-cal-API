<?php

namespace Database\Seeders;

use App\Models\Dish;
use App\Models\DishIngredient;
use App\Models\Ingredient;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class DishIngredientSeeder extends Seeder
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

        $kg = Unit::where('symbol', 'Kg')->first();
        $g = Unit::where('symbol', 'g')->first();
        $dozen = Unit::where('symbol', 'Dozen')->first();
        $pcs = Unit::where('symbol', 'pcs')->first();
        $l = Unit::where('symbol', 'L')->first();
        $ml = Unit::where('symbol', 'ml')->first();

        // Ingredients lookup
        $rice = Ingredient::where('name', 'Basmati Rice')->first();
        $eggs = Ingredient::where('name', 'Eggs')->first();
        $soy = Ingredient::where('name', 'Soy Sauce')->first();
        $chicken = Ingredient::where('name', 'Raw Chicken')->first();

        // Helper closure to create + backfill
        $createWithData = function (array $fields) {
            $model = DishIngredient::create($fields);

            $attributes = $model->getAttributes();
            unset($attributes['created_at'], $attributes['updated_at'], $attributes['deleted_at']);

            $model->updateQuietly(['data' => $attributes]);
        };

        // Attach Basmati Rice
        if ($rice && $g && $kg) {
            $createWithData([
                'dish_id' => $friedRice->id,
                'ingredient_id' => $rice->id,
                'default_recipe_qty' => 250.0000,
                'unit_id' => $g->id,
                'default_cost_per_unit' => 200.0000, // $200 per Kg
                'cost_unit_id' => $kg->id,
                'default_wastage_qty' => 0.0000,
                'wastage_unit_id' => $g->id,
            ]);
        }

        // Attach Eggs
        if ($eggs && $pcs && $dozen) {
            $createWithData([
                'dish_id' => $friedRice->id,
                'ingredient_id' => $eggs->id,
                'default_recipe_qty' => 2.0000,
                'unit_id' => $pcs->id,
                'default_cost_per_unit' => 180.0000, // $180 per Dozen
                'cost_unit_id' => $dozen->id,
                'default_wastage_qty' => 0.0000,
                'wastage_unit_id' => $pcs->id,
            ]);
        }

        // Attach Soy Sauce
        if ($soy && $ml && $l) {
            $createWithData([
                'dish_id' => $friedRice->id,
                'ingredient_id' => $soy->id,
                'default_recipe_qty' => 15.0000,
                'unit_id' => $ml->id,
                'default_cost_per_unit' => 450.0000, // $450 per Liter
                'cost_unit_id' => $l->id,
                'default_wastage_qty' => 0.0000,
                'wastage_unit_id' => $ml->id,
            ]);
        }

        // Attach Chicken
        if ($chicken && $g && $kg) {
            $createWithData([
                'dish_id' => $friedRice->id,
                'ingredient_id' => $chicken->id,
                'default_recipe_qty' => 200.0000,
                'unit_id' => $g->id,
                'default_cost_per_unit' => 1200.0000, // $1200 per Kg
                'cost_unit_id' => $kg->id,
                'default_wastage_qty' => 50.0000,
                'wastage_unit_id' => $g->id,
                'default_wastage_sell_price' => 400.0000, // Sell wastage at $400/Kg
            ]);
        }
    }
}
