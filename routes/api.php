<?php

use App\Http\Controllers\DishController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('/dish')->group(function () {
   Route::get('/', [DishController::class, 'index']);
   Route::post('/create', [DishController::class, 'store']);
   Route::patch('/update', [DishController::class, 'update']);
   Route::get('/{dish_id}', [DishController::class, 'show']);
   Route::delete('/delete', [DishController::class, 'delete']);
});