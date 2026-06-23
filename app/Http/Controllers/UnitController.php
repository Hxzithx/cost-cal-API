<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;

class UnitController extends Controller
{

   public function index()
   {
      try {
         $units = Unit::all();

         return response()->json([
            'message' => 'Units retrieved successfully',
            'units' => $units,
         ], 200);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occured while retrieving units',
            'error' => $e->getMessage(),
         ], 500);
      }
   }

   public function store(Request $request)
   {
      try {
         $fields = $request->validate([
            'name' => 'required|string|max:255|unique:units,name',
            'symbol' => 'required|string|max:50|unique:units,symbol',
            'data' => 'nullable|array',
         ]);

         $unit = Unit::create($fields);

         return response()->json([
            'message' => 'Unit created successfully',
            'unit' => $unit,
         ], 201);
      } catch (ValidationException $e) {
         return response()->json([
            'message' => 'Validation failed',
            'error' => $e->errors(),
         ], 422);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occured while creating unit',
            'error' => $e->getMessage(),
         ], 500);
      }
   }

   public function show(Unit $unit)
   {
      try {
         return response()->json([
            'message' => 'Unit retrieved successfully',
            'unit' => $unit,
         ], 200);
      } catch (ModelNotFoundException $e) {
         return response()->json([
            'message' => 'Model not found',
            'error' => $e->getMessage(),
         ], 404);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occured while retrieving unit',
            'error' => $e->getMessage(),
         ], 500);
      }
   }

   public function update(Request $request, Unit $unit)
   {
      try {
         $fields = $request->validate([
            'name' => 'sometimes|required|string|max:255|unique:units,name,' . $unit->id,
            'symbol' => 'sometimes|required|string|max:50|unique:units,symbol,' . $unit->id,
            'data' => 'sometimes|nullable|array',
         ]);

         $unit->update($fields);

         return response()->json([
            'message' => 'Unit updated successfully',
            'unit' => $unit,
         ], 200);
      } catch (ValidationException $e) {
         return response()->json([
            'message' => 'Validation failed',
            'error' => $e->errors(),
         ], 422);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occurred while updating unit',
            'error' => $e->getMessage(),
         ], 500);
      }
   }

   public function destroy(Unit $unit)
   {
      try {
         $unit->delete();

         return response()->json([
            'message' => 'Unit deleted successfully',
         ], 200);
      } catch (QueryException $e) {
         if (
            strpos($e->getMessage(), 'foreign key constraint') !== false ||
            strpos($e->getMessage(), 'SQLSTATE[23000]') !== false
         ) {
            return response()->json([
               'message' => 'Cannot delete unit as it is currently in use',
               'error' => 'This unit is referenced by one or more conversions, dishes, or other records',
            ], 409);
         }

         return response()->json([
            'message' => 'A database error occurred while deleting unit',
            'error' => $e->getMessage(),
         ], 500);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occurred while deleting unit',
            'error' => $e->getMessage(),
         ], 500);
      }
   }
}