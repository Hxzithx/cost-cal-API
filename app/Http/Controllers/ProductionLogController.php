<?php

namespace App\Http\Controllers;

use App\Models\ProductionLog;
use Exception;
use Illuminate\Http\Request;

class ProductionLogController extends Controller
{
    public function index()
    {
        try {
            $logs = ProductionLog::orderBy('id', 'desc')->get();
            return response()->json([
                'message' => 'Production logs retrieved successfully',
                'production_logs' => $logs,
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $fields = $request->validate([
                'dish_id' => 'nullable',
                'dish_name' => 'required|string',
                'produced_qty' => 'required|numeric',
                'total_cost' => 'nullable|numeric',
                'produced_at' => 'required|string',
                'consumed_batches' => 'nullable|array',
            ]);

            $log = ProductionLog::create($fields);

            return response()->json([
                'message' => 'Production log created successfully',
                'production_log' => $log,
            ], 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
