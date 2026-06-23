<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;

class DishController extends Controller
{

   public function index()
   {
      try {
         $dish = Dish::all();

         return response()->json([
            'message' => 'Dishes retrieved successfully',
            'dishes' => $dish,
         ], 200);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occured while retrieving dishes',
            'error' => $e->getMessage(),
         ], 500);
      }
   }

   public function store(Request $request)
   {
      try {
         $fields = $request->validate([
            'name' => 'required|string|max:255|unique:dishes,name',
            'description' => 'nullable|string',
            'data' => 'nullable|array',
            'is_active' => 'boolean',
         ]);

         $dish = Dish::create($fields);

         return response()->json([
            'message' => 'Dish created successfully',
            'dish' => $dish,
         ], 201);
      } catch (ValidationException $e) {
         return response()->json([
            'message' => 'Validation failed',
            'error' => $e->errors(),
         ], 422);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occured while creating dish',
            'error' => $e->getMessage(),
         ], 500);
      }
   }

   public function show(Dish $dish)
   {
      try {
         return response()->json([
            'message' => 'Dish retrieved successfully',
            'dish' => $dish,
         ], 200);
      } catch (ModelNotFoundException $e) {
         return response()->json([
            'message' => 'Model not found',
            'error' => $e->getMessage(),
         ], 404);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occured while retrieving dish',
            'error' => $e->getMessage(),
         ], 500);
      }
   }

   public function update(Request $request, Dish $dish)
   {
      try {
         $fields = $request->validate([
            'name' => 'sometimes|required|string|max:255|unique:dishes,name,' . $dish->id,
            'description' => 'sometimes|nullable|string',
            'data' => 'sometimes|nullable|array',
            'is_active' => 'boolean',
         ]);

         $dish->update($fields);

         return response()->json([
            'message' => 'Dish updated successfully',
            'dish' => $dish,
         ], 200);
      } catch (ValidationException $e) {
         return response()->json([
            'message' => 'Validation failed',
            'error' => $e->errors(),
         ], 422);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occurred while updating dish',
            'error' => $e->getMessage(),
         ], 500);
      }
   }

   public function destroy(Dish $dish)
   {
      try {
         $dish->delete();

         return response()->json([
            'message' => 'Dish deleted successfully',
         ], 200);
      } catch (QueryException $e) {
         if (
            strpos($e->getMessage(), 'foreign key constraint') !== false ||
            strpos($e->getMessage(), 'SQLSTATE[23000]') !== false
         ) {
            return response()->json([
               'message' => 'Cannot delete dish as it is currently in use',
               'error' => 'This dish is referenced by other records',
            ], 409);
         }

         return response()->json([
            'message' => 'A database error occurred while deleting dish',
            'error' => $e->getMessage(),
         ], 500);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occurred while deleting dish',
            'error' => $e->getMessage(),
         ], 500);
      }
   }
}
