<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class DishController extends Controller
{

       public function index()
       {
        $dish = Dish::all();

        return response()->json([
           'message' => 'Dishes retrieved successfully',
           'dishes' => $dish,
        ],200);
       }
}
