<?php

namespace App\Http\Controllers;

use App\Models\UnitConversion;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;

class UnitConversionController extends Controller
{

   public function index()
   {
      try {
         $conversions = UnitConversion::with(['parentUnit', 'childUnit'])->get();

         return response()->json([
            'message' => 'Unit conversions retrieved successfully',
            'unit_conversions' => $conversions,
         ], 200);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occured while retrieving unit conversions',
            'error' => $e->getMessage(),
         ], 500);
      }
   }

   public function store(Request $request)
   {
      try {
         $fields = $request->validate([
            'parent_unit_id' => 'required|exists:units,id',
            'child_unit_id' => 'required|exists:units,id|different:parent_unit_id',
            'factor' => 'required|numeric|gt:0',
            'data' => 'nullable|array',
         ]);

         $exists = UnitConversion::where('parent_unit_id', $fields['parent_unit_id'])
            ->where('child_unit_id', $fields['child_unit_id'])
            ->exists();

         if ($exists) {
            return response()->json([
               'message' => 'Validation failed',
               'error' => [
                  'child_unit_id' => ['A conversion between these units already exists.']
               ],
            ], 422);
         }

         $unitConversion = UnitConversion::create($fields);

         return response()->json([
            'message' => 'Unit conversion created successfully',
            'unit_conversion' => $unitConversion->load(['parentUnit', 'childUnit']),
         ], 201);
      } catch (ValidationException $e) {
         return response()->json([
            'message' => 'Validation failed',
            'error' => $e->errors(),
         ], 422);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occured while creating unit conversion',
            'error' => $e->getMessage(),
         ], 500);
      }
   }

   public function show(UnitConversion $unitConversion)
   {
      try {
         $unitConversion->load(['parentUnit', 'childUnit']);

         return response()->json([
            'message' => 'Unit conversion retrieved successfully',
            'unit_conversion' => $unitConversion,
         ], 200);
      } catch (ModelNotFoundException $e) {
         return response()->json([
            'message' => 'Model not found',
            'error' => $e->getMessage(),
         ], 404);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occured while retrieving unit conversion',
            'error' => $e->getMessage(),
         ], 500);
      }
   }

   public function update(Request $request, UnitConversion $unitConversion)
   {
      try {
         $fields = $request->validate([
            'parent_unit_id' => 'sometimes|required|exists:units,id',
            'child_unit_id' => 'sometimes|required|exists:units,id|different:parent_unit_id',
            'factor' => 'sometimes|required|numeric|gt:0',
            'data' => 'sometimes|nullable|array',
         ]);

         $parentUnitId = $fields['parent_unit_id'] ?? $unitConversion->parent_unit_id;
         $childUnitId = $fields['child_unit_id'] ?? $unitConversion->child_unit_id;

         if (
            ($parentUnitId != $unitConversion->parent_unit_id || $childUnitId != $unitConversion->child_unit_id) &&
            UnitConversion::where('parent_unit_id', $parentUnitId)
               ->where('child_unit_id', $childUnitId)
               ->where('id', '!=', $unitConversion->id)
               ->exists()
         ) {
            return response()->json([
               'message' => 'Validation failed',
               'error' => [
                  'child_unit_id' => ['A conversion between these units already exists.']
               ],
            ], 422);
         }

         $unitConversion->update($fields);

         return response()->json([
            'message' => 'Unit conversion updated successfully',
            'unit_conversion' => $unitConversion->load(['parentUnit', 'childUnit']),
         ], 200);
      } catch (ValidationException $e) {
         return response()->json([
            'message' => 'Validation failed',
            'error' => $e->errors(),
         ], 422);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occurred while updating unit conversion',
            'error' => $e->getMessage(),
         ], 500);
      }
   }

   public function destroy(UnitConversion $unitConversion)
   {
      try {
         $unitConversion->delete();

         return response()->json([
            'message' => 'Unit conversion deleted successfully',
         ], 200);
      } catch (QueryException $e) {
         if (
            strpos($e->getMessage(), 'foreign key constraint') !== false ||
            strpos($e->getMessage(), 'SQLSTATE[23000]') !== false
         ) {
            return response()->json([
               'message' => 'Cannot delete unit conversion as it is currently in use',
               'error' => 'This unit conversion is referenced by other records',
            ], 409);
         }

         return response()->json([
            'message' => 'A database error occurred while deleting unit conversion',
            'error' => $e->getMessage(),
         ], 500);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occurred while deleting unit conversion',
            'error' => $e->getMessage(),
         ], 500);
      }
   }
}
