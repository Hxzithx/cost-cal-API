<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\LaborCost;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;

class LaborCostController extends Controller
{

   public function index(Dish $dish)
   {
      try {
         $laborCosts = $dish->laborCosts;

         return response()->json([
            'message' => 'Labor costs retrieved successfully',
            'labor_costs' => $laborCosts,
         ], 200);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occured while retrieving labor costs',
            'error' => $e->getMessage(),
         ], 500);
      }
   }

   public function store(Request $request, Dish $dish)
   {
      try {
         $fields = $request->validate([
            'role_name' => 'required|string|max:255',
            'monthly_salary' => 'required|numeric|min:0',
            'monthly_hours' => 'required|numeric|min:0',
            'prep_time_minutes' => 'required|numeric|min:0',
            'data' => 'array|nullable',
         ]);

         $laborCost = $dish->laborCosts()->create($fields);

         return response()->json([
            'message' => 'Labor cost added successfully',
            'labor_cost' => $laborCost,
         ], 201);
      } catch (ValidationException $e) {
         return response()->json([
            'message' => 'Validation failed',
            'error' => $e->errors(),
         ], 422);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occured while adding labor cost',
            'error' => $e->getMessage(),
         ], 500);
      }
   }

   public function show(Dish $dish, LaborCost $laborCost)
   {
      try {
         return response()->json([
            'message' => 'Labor cost retrieved successfully',
            'labor_cost' => $laborCost,
         ], 200);
      } catch (ModelNotFoundException $e) {
         return response()->json([
            'message' => 'Model not found',
            'error' => $e->getMessage(),
         ], 404);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occured while retrieving labor cost',
            'error' => $e->getMessage(),
         ], 500);
      }
   }

   public function update(Request $request, Dish $dish, LaborCost $laborCost)
   {
      try {
         $fields = $request->validate([
            'role_name' => 'sometimes|required|string|max:255',
            'monthly_salary' => 'sometimes|required|numeric|min:0',
            'monthly_hours' => 'sometimes|required|numeric|min:0',
            'prep_time_minutes' => 'sometimes|required|numeric|min:0',
            'data' => 'array|nullable',
         ]);

         $laborCost->update($fields);

         return response()->json([
            'message' => 'Labor cost updated successfully',
            'labor_cost' => $laborCost,
         ], 200);
      } catch (ValidationException $e) {
         return response()->json([
            'message' => 'Validation failed',
            'error' => $e->errors(),
         ], 422);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occurred while updating labor cost',
            'error' => $e->getMessage(),
         ], 500);
      }
   }

   public function destroy(Dish $dish, LaborCost $laborCost)
   {
      try {
         $laborCost->delete();

         return response()->json([
            'message' => 'Labor cost deleted successfully',
         ], 200);
      } catch (QueryException $e) {
         if (
            strpos($e->getMessage(), 'foreign key constraint') !== false ||
            strpos($e->getMessage(), 'SQLSTATE[23000]') !== false
         ) {
            return response()->json([
               'message' => 'Cannot delete labor cost as it is currently in use',
               'error' => 'This labor cost is referenced by other records',
            ], 409);
         }

         return response()->json([
            'message' => 'A database error occurred while deleting labor cost',
            'error' => $e->getMessage(),
         ], 500);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occurred while deleting labor cost',
            'error' => $e->getMessage(),
         ], 500);
      }
   }
}