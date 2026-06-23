<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;

class CategoryController extends Controller
{

   public function index()
   {
      try {
         $categories = Category::all();

         return response()->json([
            'message' => 'Categories retrieved successfully',
            'categories' => $categories,
         ], 200);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occured while retrieving categories',
            'error' => $e->getMessage(),
         ], 500);
      }
   }

   public function store(Request $request)
   {
      try {
         $fields = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'data' => 'array|nullable',
            'is_active' => 'boolean',
         ]);

         $category = Category::create($fields);

         return response()->json([
            'message' => 'Category created successfully',
            'category' => $category,
         ], 201);
      } catch (ValidationException $e) {
         return response()->json([
            'message' => 'Validation failed',
            'error' => $e->errors(),
         ], 422);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occured while creating category',
            'error' => $e->getMessage(),
         ], 500);
      }
   }

   public function show(Category $category)
   {
      try {
         return response()->json([
            'message' => 'Category retrieved successfully',
            'category' => $category,
         ], 200);
      } catch (ModelNotFoundException $e) {
         return response()->json([
            'message' => 'Model not found',
            'error' => $e->getMessage(),
         ], 404);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occured while retrieving category',
            'error' => $e->getMessage(),
         ], 500);
      }
   }

   public function update(Request $request, Category $category)
   {
      try {
         $fields = $request->validate([
            'name' => 'sometimes|required|string|max:255|unique:categories,name,' . $category->id,
            'data' => 'sometimes|array|nullable',
            'is_active' => 'boolean',
         ]);

         $category->update($fields);

         return response()->json([
            'message' => 'Category updated successfully',
            'category' => $category,
         ], 200);
      } catch (ValidationException $e) {
         return response()->json([
            'message' => 'Validation failed',
            'error' => $e->errors(),
         ], 422);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occurred while updating category',
            'error' => $e->getMessage(),
         ], 500);
      }
   }

   public function destroy(Category $category)
   {
      try {
         $category->delete();

         return response()->json([
            'message' => 'Category deleted successfully',
         ], 200);
      } catch (QueryException $e) {
         if (
            strpos($e->getMessage(), 'foreign key constraint') !== false ||
            strpos($e->getMessage(), 'SQLSTATE[23000]') !== false
         ) {
            return response()->json([
               'message' => 'Cannot delete category as it is currently in use',
               'error' => 'This category is assigned to one or more dishes',
            ], 409);
         }

         return response()->json([
            'message' => 'A database error occurred while deleting category',
            'error' => $e->getMessage(),
         ], 500);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occurred while deleting category',
            'error' => $e->getMessage(),
         ], 500);
      }
   }
}