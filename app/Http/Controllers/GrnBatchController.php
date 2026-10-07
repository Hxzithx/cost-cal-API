<?php

namespace App\Http\Controllers;

use App\Models\GrnBatch;
use Exception;
use Illuminate\Http\Request;

class GrnBatchController extends Controller
{
    public function index()
    {
        try {
            $batches = GrnBatch::orderBy('id', 'desc')->get();
            return response()->json([
                'message' => 'Batches retrieved successfully',
                'batches' => $batches,
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $fields = $request->validate([
                'master_ingredient_id' => 'nullable',
                'grn_number' => 'required|string',
                'batch_number' => 'required|string',
                'supplier_id' => 'nullable',
                'supplier_name' => 'nullable|string',
                'received_date' => 'required|string',
                'expiry_date' => 'nullable|string',
                'initial_qty' => 'required|numeric',
                'remaining_qty' => 'required|numeric',
                'unit_id' => 'nullable',
                'unit_cost' => 'nullable|numeric',
                'location_id' => 'nullable',
                'location_name' => 'nullable|string',
            ]);

            $batch = GrnBatch::updateOrCreate(
                [
                    'grn_number' => $fields['grn_number'],
                    'batch_number' => $fields['batch_number'],
                ],
                $fields
            );

            return response()->json([
                'message' => 'Batch saved successfully',
                'batch' => $batch,
            ], 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $batch = GrnBatch::findOrFail($id);
            $batch->update($request->all());
            return response()->json([
                'message' => 'Batch updated successfully',
                'batch' => $batch,
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
