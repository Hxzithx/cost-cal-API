<?php

namespace App\Http\Controllers;

use App\Models\StockMovement;
use Exception;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    public function index()
    {
        try {
            $movements = StockMovement::orderBy('id', 'desc')->get();
            return response()->json([
                'message' => 'Stock movements retrieved successfully',
                'stock_movements' => $movements,
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $fields = $request->validate([
                'movement_type' => 'required|string',
                'reference_no' => 'required|string',
                'source_location_id' => 'nullable',
                'source_location_name' => 'nullable|string',
                'destination_location_id' => 'nullable',
                'destination_location_name' => 'nullable|string',
                'ingredient_id' => 'nullable',
                'ingredient_name' => 'required|string',
                'batch_no' => 'nullable|string',
                'qty' => 'required|numeric',
                'unit_id' => 'nullable',
                'unit_symbol' => 'nullable|string',
                'unit_cost' => 'nullable|numeric',
                'total_cost' => 'nullable|numeric',
                'movement_date' => 'required|string',
                'reason' => 'nullable|string',
                'notes' => 'nullable|string',
                'status' => 'nullable|string',
            ]);

            $movement = StockMovement::create($fields);

            return response()->json([
                'message' => 'Stock movement created successfully',
                'stock_movement' => $movement,
            ], 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
