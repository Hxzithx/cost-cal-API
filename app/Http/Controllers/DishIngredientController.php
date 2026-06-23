<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\DishIngredient;
use App\Models\Ingredient;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;

class DishIngredientController extends Controller
{

   public function index(Dish $dish)
   {
      try {
         $ingredients = $dish->dishIngredients()
            ->with(['ingredient', 'unit', 'costUnit', 'wastageUnit'])
            ->get();

         return response()->json([
            'message' => 'Dish ingredients retrieved successfully',
            'ingredients' => $ingredients,
         ], 200);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occured while retrieving dish ingredients',
            'error' => $e->getMessage(),
         ], 500);
      }
   }

   public function store(Request $request, Dish $dish)
   {
      try {
         $fields = $request->validate([
            'ingredient_name' => 'required|string|max:255',
            'default_recipe_qty' => 'required|numeric',
            'unit_id' => 'required|exists:units,id',
            'default_cost_per_unit' => 'required|numeric',
            'cost_unit_id' => 'required|exists:units,id',
            'default_wastage_qty' => 'nullable|numeric',
            'wastage_unit_id' => 'nullable|exists:units,id',
            'default_wastage_sell_price' => 'nullable|numeric',
         ]);

         $ingredient = Ingredient::firstOrCreate(['name' => $fields['ingredient_name']]);

         $dishIngredient = $dish->dishIngredients()->create([
            'ingredient_id' => $ingredient->id,
            'default_recipe_qty' => $fields['default_recipe_qty'],
            'unit_id' => $fields['unit_id'],
            'default_cost_per_unit' => $fields['default_cost_per_unit'],
            'cost_unit_id' => $fields['cost_unit_id'],
            'default_wastage_qty' => $fields['default_wastage_qty'] ?? 0,
            'wastage_unit_id' => $fields['wastage_unit_id'] ?? null,
            'default_wastage_sell_price' => $fields['default_wastage_sell_price'] ?? 0,
         ]);

         return response()->json([
            'message' => 'Ingredient added to dish successfully',
            'dish_ingredient' => $dishIngredient->load(['ingredient', 'unit', 'costUnit', 'wastageUnit']),
         ], 201);
      } catch (ValidationException $e) {
         return response()->json([
            'message' => 'Validation failed',
            'error' => $e->errors(),
         ], 422);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occured while adding ingredient to dish',
            'error' => $e->getMessage(),
         ], 500);
      }
   }

   public function show(Dish $dish, DishIngredient $dishIngredient)
   {
      try {
         $dishIngredient->load(['ingredient', 'unit', 'costUnit', 'wastageUnit']);

         return response()->json([
            'message' => 'Dish ingredient retrieved successfully',
            'dish_ingredient' => $dishIngredient,
         ], 200);
      } catch (ModelNotFoundException $e) {
         return response()->json([
            'message' => 'Model not found',
            'error' => $e->getMessage(),
         ], 404);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occured while retrieving dish ingredient',
            'error' => $e->getMessage(),
         ], 500);
      }
   }

   public function update(Request $request, Dish $dish, DishIngredient $dishIngredient)
   {
      try {
         $fields = $request->validate([
            'default_recipe_qty' => 'sometimes|required|numeric',
            'unit_id' => 'sometimes|required|exists:units,id',
            'default_cost_per_unit' => 'sometimes|required|numeric',
            'cost_unit_id' => 'sometimes|required|exists:units,id',
            'default_wastage_qty' => 'sometimes|nullable|numeric',
            'wastage_unit_id' => 'sometimes|nullable|exists:units,id',
            'default_wastage_sell_price' => 'sometimes|nullable|numeric',
         ]);

         $dishIngredient->update($fields);

         return response()->json([
            'message' => 'Dish ingredient updated successfully',
            'dish_ingredient' => $dishIngredient->load(['ingredient', 'unit', 'costUnit', 'wastageUnit']),
         ], 200);
      } catch (ValidationException $e) {
         return response()->json([
            'message' => 'Validation failed',
            'error' => $e->errors(),
         ], 422);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occurred while updating dish ingredient',
            'error' => $e->getMessage(),
         ], 500);
      }
   }

   public function destroy(Dish $dish, DishIngredient $dishIngredient)
   {
      try {
         $dishIngredient->delete();

         return response()->json([
            'message' => 'Ingredient removed from dish successfully',
         ], 200);
      } catch (QueryException $e) {
         if (
            strpos($e->getMessage(), 'foreign key constraint') !== false ||
            strpos($e->getMessage(), 'SQLSTATE[23000]') !== false
         ) {
            return response()->json([
               'message' => 'Cannot remove ingredient as it is currently in use',
               'error' => 'This dish ingredient is referenced by other records',
            ], 409);
         }

         return response()->json([
            'message' => 'A database error occurred while removing ingredient from dish',
            'error' => $e->getMessage(),
         ], 500);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occurred while removing ingredient from dish',
            'error' => $e->getMessage(),
         ], 500);
      }
   }
}