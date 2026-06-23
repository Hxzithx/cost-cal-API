<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\OverheadCost;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;

class OverheadCostController extends Controller
{

   public function index(Dish $dish)
   {
      try {
         $overheadCosts = $dish->overheadCosts;

         return response()->json([
            'message' => 'Overhead costs retrieved successfully',
            'overhead_costs' => $overheadCosts,
         ], 200);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occured while retrieving overhead costs',
            'error' => $e->getMessage(),
         ], 500);
      }
   }

   public function store(Request $request, Dish $dish)
   {
      try {
         $fields = $request->validate([
            'expense_name' => 'required|string|max:255',
            'monthly_cost' => 'required|numeric|min:0',
            'monthly_yield' => 'required|numeric|min:0',
            'data' => 'array|nullable',
         ]);

         $overheadCost = $dish->overheadCosts()->create($fields);

         return response()->json([
            'message' => 'Overhead cost added successfully',
            'overhead_cost' => $overheadCost,
         ], 201);
      } catch (ValidationException $e) {
         return response()->json([
            'message' => 'Validation failed',
            'error' => $e->errors(),
         ], 422);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occured while adding overhead cost',
            'error' => $e->getMessage(),
         ], 500);
      }
   }

   public function show(Dish $dish, OverheadCost $overheadCost)
   {
      try {
         return response()->json([
            'message' => 'Overhead cost retrieved successfully',
            'overhead_cost' => $overheadCost,
         ], 200);
      } catch (ModelNotFoundException $e) {
         return response()->json([
            'message' => 'Model not found',
            'error' => $e->getMessage(),
         ], 404);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occured while retrieving overhead cost',
            'error' => $e->getMessage(),
         ], 500);
      }
   }

   public function update(Request $request, Dish $dish, OverheadCost $overheadCost)
   {
      try {
         $fields = $request->validate([
            'expense_name' => 'sometimes|required|string|max:255',
            'monthly_cost' => 'sometimes|required|numeric|min:0',
            'monthly_yield' => 'sometimes|required|numeric|min:0',
            'data' => 'sometimes|array|nullable',
         ]);

         $overheadCost->update($fields);

         return response()->json([
            'message' => 'Overhead cost updated successfully',
            'overhead_cost' => $overheadCost,
         ], 200);
      } catch (ValidationException $e) {
         return response()->json([
            'message' => 'Validation failed',
            'error' => $e->errors(),
         ], 422);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occurred while updating overhead cost',
            'error' => $e->getMessage(),
         ], 500);
      }
   }

   public function destroy(Dish $dish, OverheadCost $overheadCost)
   {
      try {
         $overheadCost->delete();

         return response()->json([
            'message' => 'Overhead cost deleted successfully',
         ], 200);
      } catch (QueryException $e) {
         if (
            strpos($e->getMessage(), 'foreign key constraint') !== false ||
            strpos($e->getMessage(), 'SQLSTATE[23000]') !== false
         ) {
            return response()->json([
               'message' => 'Cannot delete overhead cost as it is currently in use',
               'error' => 'This overhead cost is referenced by other records',
            ], 409);
         }

         return response()->json([
            'message' => 'A database error occurred while deleting overhead cost',
            'error' => $e->getMessage(),
         ], 500);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occurred while deleting overhead cost',
            'error' => $e->getMessage(),
         ], 500);
      }
   }
}