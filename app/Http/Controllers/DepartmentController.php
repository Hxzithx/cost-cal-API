<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Exception;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        try {
            $departments = Department::all();
            return response()->json([
                'message' => 'Departments retrieved successfully',
                'departments' => $departments,
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
            ]);

            $department = Department::updateOrCreate(
                ['code' => $fields['code']],
                $fields
            );

            return response()->json([
                'message' => 'Department saved successfully',
                'department' => $department,
            ], 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
