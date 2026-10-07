<?php

namespace App\Http\Controllers;

use App\Models\PosDailySale;
use Exception;
use Illuminate\Http\Request;

class PosDailySaleController extends Controller
{
    public function index()
    {
        try {
            $sales = PosDailySale::orderBy('id', 'desc')->get();
            return response()->json([
                'message' => 'POS daily sales retrieved successfully',
                'pos_daily_sales' => $sales,
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $fields = $request->validate([
                'sale_date' => 'required|string',
                'dish_id' => 'nullable',
                'dish_name' => 'required|string',
                'sold_qty' => 'required|numeric',
                'unit_price' => 'nullable|numeric',
                'total_revenue' => 'nullable|numeric',
                'produced_qty_today' => 'nullable|numeric',
                'variance_qty' => 'nullable|numeric',
                'notes' => 'nullable|string',
            ]);

            $sale = PosDailySale::create($fields);

            return response()->json([
                'message' => 'POS daily sale recorded successfully',
                'pos_daily_sale' => $sale,
            ], 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
