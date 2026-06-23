<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\DishIngredientController;
use App\Http\Controllers\IngredientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('/dish')->group(function () {
    Route::get('/', [DishController::class, 'index']);
    Route::post('/', [DishController::class, 'store']);
    Route::put('/{dish_id}', [DishController::class, 'update']);
    Route::get('/{dish_id}', [DishController::class, 'show']);
    Route::delete('/{dish_id}', [DishController::class, 'delete']);
});

Route::prefix('/dish-ingredient/{dish_id}')->group(function () {
    Route::get('/', [DishIngredientController::class, 'index']);
    Route::post('/', [DishIngredientController::class, 'store']);
    Route::put('{dishingredient}', [DishIngredientController::class, 'update']);
    Route::get('/{dishingredient}', [DishIngredientController::class, 'show']);
    Route::delete('/{dishingredient}', [DishIngredientController::class, 'delete']);
});

Route::prefix('/categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::post('/', [CategoryController::class, 'store']);
    Route::put('/{category_id}', [CategoryController::class, 'update']);
    Route::get('/{category_id}', [CategoryController::class, 'show']);
    Route::delete('/{category_id}', [CategoryController::class, 'delete']);
});

Route::prefix('/ingredients')->group(function () {
    Route::get('/', [IngredientController::class, 'index']);
    Route::post('/', [IngredientController::class, 'store']);
    Route::put('/{ingredient_id}', [IngredientController::class, 'update']);
    Route::get('/{ingredient_id}', [IngredientController::class, 'show']);
    Route::delete('/{ingredient_id}', [IngredientController::class, 'delete']);
});
