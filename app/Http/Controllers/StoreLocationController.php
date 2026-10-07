<?php

namespace App\Http\Controllers;

use App\Models\StoreLocation;
use Exception;
use Illuminate\Http\Request;

class StoreLocationController extends Controller
{
    public function index()
    {
        try {
            $locations = StoreLocation::all();
            return response()->json([
                'message' => 'Store locations retrieved successfully',
                'store_locations' => $locations,
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $fields = $request->validate([
                'code' => 'required|string|max:100',
                'name' => 'required|string|max:255',
                'type' => 'nullable|string|max:100',
                'address' => 'nullable|string',
                'is_active' => 'boolean',
            ]);

            $location = StoreLocation::updateOrCreate(
                ['code' => $fields['code']],
                $fields
            );

            return response()->json([
                'message' => 'Store location saved successfully',
                'store_location' => $location,
            ], 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $location = StoreLocation::findOrFail($id);
            $location->update($request->all());
            return response()->json([
                'message' => 'Store location updated successfully',
                'store_location' => $location,
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
