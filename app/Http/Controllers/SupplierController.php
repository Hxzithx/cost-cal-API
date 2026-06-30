<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;

class SupplierController extends Controller
{

   public function index()
   {
      try {
         $suppliers = Supplier::all();

         return response()->json([
            'message' => 'Suppliers retrieved successfully',
            'suppliers' => $suppliers,
         ], 200);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occured while retrieving suppliers',
            'error' => $e->getMessage(),
         ], 500);
      }
   }

   public function store(Request $request)
   {
      try {
         $fields = $request->validate([
            'name' => 'required|string|max:255|unique:suppliers,name',
            'external_id' => 'nullable|string|max:255|unique:suppliers,external_id',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:50',
            'is_active' => 'boolean',
         ]);

         $supplier = Supplier::create($fields);

         return response()->json([
            'message' => 'Supplier created successfully',
            'supplier' => $supplier,
         ], 201);
      } catch (ValidationException $e) {
         return response()->json([
            'message' => 'Validation failed',
            'error' => $e->errors(),
         ], 422);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occured while creating supplier',
            'error' => $e->getMessage(),
         ], 500);
      }
   }

   public function show(Supplier $supplier)
   {
      try {
         return response()->json([
            'message' => 'Supplier retrieved successfully',
            'supplier' => $supplier,
         ], 200);
      } catch (ModelNotFoundException $e) {
         return response()->json([
            'message' => 'Model not found',
            'error' => $e->getMessage(),
         ], 404);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occured while retrieving supplier',
            'error' => $e->getMessage(),
         ], 500);
      }
   }

   public function update(Request $request, Supplier $supplier)
   {
      try {
         $fields = $request->validate([
            'name' => 'sometimes|required|string|max:255|unique:suppliers,name,' . $supplier->id,
            'external_id' => 'sometimes|nullable|string|max:255|unique:suppliers,external_id,' . $supplier->id,
            'contact_email' => 'sometimes|nullable|email|max:255',
            'contact_phone' => 'sometimes|nullable|string|max:50',
            'is_active' => 'boolean',
         ]);

         $supplier->update($fields);

         return response()->json([
            'message' => 'Supplier updated successfully',
            'supplier' => $supplier,
         ], 200);
      } catch (ValidationException $e) {
         return response()->json([
            'message' => 'Validation failed',
            'error' => $e->errors(),
         ], 422);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occurred while updating supplier',
            'error' => $e->getMessage(),
         ], 500);
      }
   }

   public function destroy(Supplier $supplier)
   {
      try {
         // Gate::authorize('delete', $supplier);

         $supplier->delete();

         return response()->json([
            'message' => 'Supplier deleted successfully',
         ], 200);
      } catch (AuthorizationException $e) {
         return response()->json([
            'message' => 'Unauthorized to delete supplier',
            'error' => $e->getMessage(),
         ], 403);
      } catch (QueryException $e) {
         if (
            strpos($e->getMessage(), 'foreign key constraint') !== false ||
            strpos($e->getMessage(), 'SQLSTATE[23000]') !== false
         ) {
            return response()->json([
               'message' => 'Cannot delete supplier as it is currently in use',
               'error' => 'This supplier is referenced by one or more ingredients',
            ], 409);
         }

         return response()->json([
            'message' => 'A database error occurred while deleting supplier',
            'error' => $e->getMessage(),
         ], 500);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occurred while deleting supplier',
            'error' => $e->getMessage(),
         ], 500);
      }
   }
}