<?php

use App\Http\Controllers\DishController;
use App\Http\Controllers\DishIngredientController;
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
