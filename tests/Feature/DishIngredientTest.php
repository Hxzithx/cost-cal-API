<?php

// namespace Tests\Feature;

// use App\Models\Dish;
// use App\Models\Ingredient;
// use App\Models\Unit;
// use App\Models\UnitConversion;
// use Illuminate\Foundation\Testing\RefreshDatabase;
// use Illuminate\Database\QueryException;
// use Tests\TestCase;

// class DishIngredientTest extends TestCase
// {
//     use RefreshDatabase;

//     public function test_can_create_units_and_conversions(): void
//     {
//         // 1. Create units
//         $kg = Unit::create(['name' => 'Kilogram', 'symbol' => 'Kg']);
//         $g = Unit::create(['name' => 'Gram', 'symbol' => 'g']);

//         $this->assertDatabaseHas('units', ['symbol' => 'Kg']);
//         $this->assertDatabaseHas('units', ['symbol' => 'g']);

//         // 2. Create conversion
//         $conversion = UnitConversion::create([
//             'parent_unit_id' => $kg->id,
//             'child_unit_id' => $g->id,
//             'factor' => 1000.0000,
//         ]);

//         $this->assertDatabaseHas('unit_conversation', [
//             'parent_unit_id' => $kg->id,
//             'child_unit_id' => $g->id,
//             'factor' => 1000.0000,
//         ]);

//         $this->assertEquals('Kg', $conversion->parentUnit->symbol);
//         $this->assertEquals('g', $conversion->childUnit->symbol);
//         $this->assertCount(1, $kg->conversions);
//     }

//     public function test_can_create_ingredients_and_dishes_with_relations(): void
//     {
//         // Create base units
//         $kg = Unit::create(['name' => 'Kilogram', 'symbol' => 'Kg']);
//         $g = Unit::create(['name' => 'Gram', 'symbol' => 'g']);
//         $dozen = Unit::create(['name' => 'Dozen', 'symbol' => 'Dozen']);
//         $pcs = Unit::create(['name' => 'Pieces', 'symbol' => 'pcs']);
//         $l = Unit::create(['name' => 'Liter', 'symbol' => 'L']);
//         $ml = Unit::create(['name' => 'Milliliter', 'symbol' => 'ml']);

//         // Create unit conversions
//         UnitConversion::create(['parent_unit_id' => $kg->id, 'child_unit_id' => $g->id, 'factor' => 1000.0000]);
//         UnitConversion::create(['parent_unit_id' => $dozen->id, 'child_unit_id' => $pcs->id, 'factor' => 12.0000]);
//         UnitConversion::create(['parent_unit_id' => $l->id, 'child_unit_id' => $ml->id, 'factor' => 1000.0000]);

//         // Create ingredients
//         $basmatiRice = Ingredient::create([
//             'name' => 'Basmati Rice',
//             'cost_price' => 200.0000,
//             'purchase_unit_id' => $kg->id,
//             'wastage_sell_price' => 0.0000,
//             'wastage_sell_unit_id' => $kg->id,
//         ]);

//         $eggs = Ingredient::create([
//             'name' => 'Eggs',
//             'cost_price' => 180.0000,
//             'purchase_unit_id' => $dozen->id,
//             'wastage_sell_price' => 0.0000,
//             'wastage_sell_unit_id' => $dozen->id,
//         ]);

//         $soySauce = Ingredient::create([
//             'name' => 'Soy Sauce',
//             'cost_price' => 450.0000,
//             'purchase_unit_id' => $l->id,
//             'wastage_sell_price' => 0.0000,
//             'wastage_sell_unit_id' => $l->id,
//         ]);

//         $rawChicken = Ingredient::create([
//             'name' => 'Raw Chicken',
//             'cost_price' => 1200.0000,
//             'purchase_unit_id' => $kg->id,
//             'wastage_sell_price' => 400.0000,
//             'wastage_sell_unit_id' => $kg->id,
//         ]);

//         $this->assertEquals('Kg', $basmatiRice->purchaseUnit->symbol);
//         $this->assertEquals('Dozen', $eggs->purchaseUnit->symbol);
//         $this->assertEquals('L', $soySauce->purchaseUnit->symbol);
//         $this->assertEquals('Kg', $rawChicken->wastageSellUnit->symbol);

//         // Create Dish
//         $friedRice = Dish::create([
//             'name' => 'Fried Rice',
//             'description' => 'Delicious classic restaurant-style fried rice with seasoned vegetables and eggs.',
//         ]);

//         $this->assertDatabaseHas('dishes', ['name' => 'Fried Rice']);

//         // Attach ingredients to dish (Recipe details)
//         $friedRice->ingredients()->attach($basmatiRice->id, [
//             'quantity' => 250.0000,
//             'unit_id' => $g->id,
//             'wastage_quantity' => 0.0000,
//             'wastage_unit_id' => $g->id,
//         ]);

//         $friedRice->ingredients()->attach($eggs->id, [
//             'quantity' => 2.0000,
//             'unit_id' => $pcs->id,
//             'wastage_quantity' => 0.0000,
//             'wastage_unit_id' => $pcs->id,
//         ]);

//         $friedRice->ingredients()->attach($soySauce->id, [
//             'quantity' => 15.0000,
//             'unit_id' => $ml->id,
//             'wastage_quantity' => 0.0000,
//             'wastage_unit_id' => $ml->id,
//         ]);

//         $friedRice->ingredients()->attach($rawChicken->id, [
//             'quantity' => 200.0000,
//             'unit_id' => $g->id,
//             'wastage_quantity' => 50.0000,
//             'wastage_unit_id' => $g->id,
//         ]);

//         // Assert relationships
//         $this->assertCount(4, $friedRice->ingredients);
//         $this->assertCount(1, $basmatiRice->dishes);
//         $this->assertCount(1, $eggs->dishes);

//         // Retrieve and check values
//         $chickenIngredient = $friedRice->ingredients()->where('name', 'Raw Chicken')->first();
//         $this->assertNotNull($chickenIngredient);
//         $this->assertEquals(200.0000, $chickenIngredient->pivot->quantity);
//         $this->assertEquals(50.0000, $chickenIngredient->pivot->wastage_quantity);

//         // Verify units from custom Pivot model
//         $this->assertEquals('g', $chickenIngredient->pivot->unit->symbol);
//         $this->assertEquals('g', $chickenIngredient->pivot->wastageUnit->symbol);

//         // Verify eggs quantities and units
//         $eggIngredient = $friedRice->ingredients()->where('name', 'Eggs')->first();
//         $this->assertNotNull($eggIngredient);
//         $this->assertEquals(2.0000, $eggIngredient->pivot->quantity);
//         $this->assertEquals('pcs', $eggIngredient->pivot->unit->symbol);
//     }

//     public function test_cannot_add_duplicate_ingredient_to_same_dish(): void
//     {
//         $kg = Unit::create(['name' => 'Kilogram', 'symbol' => 'Kg']);
//         $g = Unit::create(['name' => 'Gram', 'symbol' => 'g']);

//         $basmatiRice = Ingredient::create([
//             'name' => 'Basmati Rice',
//             'cost_price' => 200.0000,
//             'purchase_unit_id' => $kg->id,
//         ]);

//         $friedRice = Dish::create([
//             'name' => 'Fried Rice',
//         ]);

//         $friedRice->ingredients()->attach($basmatiRice->id, [
//             'quantity' => 250.0000,
//             'unit_id' => $g->id,
//         ]);

//         // Attempting to attach again should fail due to unique constraint
//         $this->expectException(QueryException::class);
        
//         $friedRice->ingredients()->attach($basmatiRice->id, [
//             'quantity' => 100.0000,
//             'unit_id' => $g->id,
//         ]);
//     }
// }
