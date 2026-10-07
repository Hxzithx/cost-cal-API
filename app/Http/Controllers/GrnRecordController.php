<?php

namespace App\Http\Controllers;

use App\Models\GrnRecord;
use Exception;
use Illuminate\Http\Request;

class GrnRecordController extends Controller
{
    public function index()
    {
        try {
            $records = GrnRecord::orderBy('id', 'desc')->get();
            return response()->json([
                'message' => 'GRN records retrieved successfully',
                'grn_records' => $records,
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $fields = $request->validate([
                'grn_no' => 'required|string',
                'po_no' => 'nullable|string',
                'ref_no' => 'nullable|string',
                'is_consignment' => 'boolean',
                'grn_date' => 'required|string',
                'supplier_id' => 'nullable',
                'supplier_name' => 'nullable|string',
                'cost_centre' => 'nullable|string',
                'po_status' => 'nullable|string',
                'payment_term' => 'nullable|string',
                'location_id' => 'nullable',
                'location_name' => 'nullable|string',
                'line_items' => 'nullable|array',
                'financials' => 'nullable|array',
                'status' => 'nullable|string',
            ]);

            $record = GrnRecord::updateOrCreate(
                ['grn_no' => $fields['grn_no']],
                $fields
            );

            return response()->json([
                'message' => 'GRN record saved successfully',
                'grn_record' => $record,
            ], 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $record = GrnRecord::findOrFail($id);
            $record->update($request->all());
            return response()->json([
                'message' => 'GRN record updated successfully',
                'grn_record' => $record,
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
