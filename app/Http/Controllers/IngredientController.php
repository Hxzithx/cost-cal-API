<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;

class IngredientController extends Controller
{

   public function index()
   {
      try {
         $ingredients = Ingredient::all();

         return response()->json([
            'message' => 'Ingredients retrieved successfully',
            'ingredients' => $ingredients,
         ], 200);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occured while retrieving ingredients',
            'error' => $e->getMessage(),
         ], 500);
      }
   }

   public function store(Request $request)
   {
      try {
         $fields = $request->validate([
            'name' => 'required|string|max:255|unique:ingredients,name',
            'description' => 'nullable|string',
            'external_id' => 'nullable|string|max:255|unique:ingredients,external_id',
            'category_id' => 'nullable|exists:categories,id',
            'stock_qty' => 'nullable|numeric|min:0',
            'stock_unit_id' => 'nullable|exists:units,id',
            'min_level_qty' => 'nullable|numeric|min:0',
            'wastage_per_unit' => 'nullable|numeric|min:0',
            'cost_per_unit' => 'nullable|numeric|min:0',
            'cost_unit_id' => 'nullable|exists:units,id',
            'supplier_name' => 'nullable|string|max:255',
            'is_active' => 'boolean',
         ]);

         $ingredient = Ingredient::create($fields);

         return response()->json([
            'message' => 'Ingredient created successfully',
            'ingredient' => $ingredient,
         ], 201);
      } catch (ValidationException $e) {
         return response()->json([
            'message' => 'Validation failed',
            'error' => $e->errors(),
         ], 422);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occured while creating ingredient',
            'error' => $e->getMessage(),
         ], 500);
      }
   }

   public function show(Ingredient $ingredient)
   {
      try {
         return response()->json([
            'message' => 'Ingredient retrieved successfully',
            'ingredient' => $ingredient,
         ], 200);
      } catch (ModelNotFoundException $e) {
         return response()->json([
            'message' => 'Model not found',
            'error' => $e->getMessage(),
         ], 404);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occured while retrieving ingredient',
            'error' => $e->getMessage(),
         ], 500);
      }
   }

   public function update(Request $request, Ingredient $ingredient)
   {
      try {
         $fields = $request->validate([
            'name' => 'sometimes|required|string|max:255|unique:ingredients,name,' . $ingredient->id,
            'description' => 'sometimes|nullable|string',
            'external_id' => 'sometimes|nullable|string|max:255|unique:ingredients,external_id,' . $ingredient->id,
            'category_id' => 'sometimes|nullable|exists:categories,id',
            'stock_qty' => 'sometimes|nullable|numeric|min:0',
            'stock_unit_id' => 'sometimes|nullable|exists:units,id',
            'min_level_qty' => 'sometimes|nullable|numeric|min:0',
            'wastage_per_unit' => 'sometimes|nullable|numeric|min:0',
            'cost_per_unit' => 'sometimes|nullable|numeric|min:0',
            'cost_unit_id' => 'sometimes|nullable|exists:units,id',
            'supplier_name' => 'sometimes|nullable|string|max:255',
            'is_active' => 'boolean',
         ]);

         $ingredient->update($fields);

         return response()->json([
            'message' => 'Ingredient updated successfully',
            'ingredient' => $ingredient,
         ], 200);
      } catch (ValidationException $e) {
         return response()->json([
            'message' => 'Validation failed',
            'error' => $e->errors(),
         ], 422);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occurred while updating ingredient',
            'error' => $e->getMessage(),
         ], 500);
      }
   }

   public function destroy(Ingredient $ingredient)
   {
      try {
         $ingredient->delete();

         return response()->json([
            'message' => 'Ingredient deleted successfully',
         ], 200);
      } catch (QueryException $e) {
         if (
            strpos($e->getMessage(), 'foreign key constraint') !== false ||
            strpos($e->getMessage(), 'SQLSTATE[23000]') !== false
         ) {
            return response()->json([
               'message' => 'Cannot delete ingredient as it is currently in use',
               'error' => 'This ingredient is referenced by one or more dishes',
            ], 409);
         }

         return response()->json([
            'message' => 'A database error occurred while deleting ingredient',
            'error' => $e->getMessage(),
         ], 500);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occurred while deleting ingredient',
            'error' => $e->getMessage(),
         ], 500);
      }
   }
}
