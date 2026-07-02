<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\DishIngredientController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\LaborCostController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UnitConversionController;
use App\Http\Controllers\OverheadCostController;
use App\Http\Controllers\SupplierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('/units')->group(function () {
    Route::get('/', [UnitController::class, 'index']);
    Route::post('/', [UnitController::class, 'store']);
    Route::put('/{unit}', [UnitController::class, 'update']);
    Route::get('/{unit}', [UnitController::class, 'show']);
    Route::delete('/{unit}', [UnitController::class, 'destroy']);
});

Route::prefix('/dish')->group(function () {
    Route::get('/', [DishController::class, 'index']);
    Route::post('/', [DishController::class, 'store']);
    Route::put('/{dish}', [DishController::class, 'update']);
    Route::get('/{dish}', [DishController::class, 'show']);
    Route::delete('/{dish}', [DishController::class, 'destroy']);
});

Route::prefix('/ingredients')->group(function () {
    Route::get('/', [IngredientController::class, 'index']);
    Route::post('/', [IngredientController::class, 'store']);
    Route::put('/{ingredient}', [IngredientController::class, 'update']);
    Route::get('/{ingredient}', [IngredientController::class, 'show']);
    Route::delete('/{ingredient}', [IngredientController::class, 'destroy']);
});

Route::prefix('/dish-ingredient/{dish}')->group(function () {
    Route::get('/', [DishIngredientController::class, 'index']);
    Route::post('/', [DishIngredientController::class, 'store']);
    Route::put('{dishIngredient}', [DishIngredientController::class, 'update']);
    Route::get('/{dishIngredient}', [DishIngredientController::class, 'show']);
    Route::delete('/{dishIngredient}', [DishIngredientController::class, 'destroy']);
});

Route::prefix('/categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::post('/', [CategoryController::class, 'store']);
    Route::put('/{category}', [CategoryController::class, 'update']);
    Route::get('/{category}', [CategoryController::class, 'show']);
    Route::delete('/{category}', [CategoryController::class, 'destroy']);
});

Route::prefix('/unit-conversations')->group(function () {
    Route::get('/', [UnitConversionController::class, 'index']);
    Route::post('/', [UnitConversionController::class, 'store']);
    Route::get('/{unitConversion}', [UnitConversionController::class, 'show']);
    Route::put('/{unitConversion}', [UnitConversionController::class, 'update']);
    Route::delete('/{unitConversion}', [UnitConversionController::class, 'destroy']);
});

Route::prefix('labor-costs/{dish}')->group(function () {
    Route::get('/', [LaborCostController::class, 'index']);
    Route::post('/', [LaborCostController::class, 'store']);
    Route::get('/{laborCost}', [LaborCostController::class, 'show']);
    Route::put('/{laborCost}', [LaborCostController::class, 'update']);
    Route::delete('/{laborCost}', [LaborCostController::class, 'destroy']);
});

Route::prefix('overhead-costs/{dish}')->group(function () {
    Route::get('/', [OverheadCostController::class, 'index']);
    Route::post('/', [OverheadCostController::class, 'store']);
    Route::get('/{overheadCost}', [OverheadCostController::class, 'show']);
    Route::put('/{overheadCost}', [OverheadCostController::class, 'update']);
    Route::delete('/{overheadCost}', [OverheadCostController::class, 'destroy']);
});

Route::prefix('/suppliers')->group(function () {
    Route::get('/', [SupplierController::class, 'index']);
    Route::post('/', [SupplierController::class, 'store']);
    Route::put('/{supplier}', [SupplierController::class, 'update']);
    Route::get('/{supplier}', [SupplierController::class, 'show']);
    Route::delete('/{supplier}', [SupplierController::class, 'destroy']);
});

