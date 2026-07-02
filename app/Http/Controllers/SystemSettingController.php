<?php

namespace App\Http\Controllers;

use App\Models\SystemSetting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class SystemSettingController extends Controller
{

   public function show()
   {
      try {
         $settings = SystemSetting::instance();

         return response()->json([
            'message' => 'System settings retrieved successfully',
            'settings' => $settings,
         ], 200);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occured while retrieving system settings',
            'error' => $e->getMessage(),
         ], 500);
      }
   }

   public function update(Request $request)
   {
      try {
         $fields = $request->validate([
            'currency_symbol' => 'sometimes|required|string|max:10',
            'default_wastage_margin' => 'sometimes|required|numeric|min:0|max:100',
            'standard_labor_hours_per_month' => 'sometimes|required|numeric|min:1',
            'pricing_calculation_method' => ['sometimes', 'required', Rule::in(['margin', 'markup'])],
            'target_gross_margin' => 'sometimes|required|numeric|min:0|max:100',
         ]);

         $settings = SystemSetting::instance();
         $settings->update($fields);

         return response()->json([
            'message' => 'System settings updated successfully',
            'settings' => $settings,
         ], 200);
      } catch (ValidationException $e) {
         return response()->json([
            'message' => 'Validation failed',
            'error' => $e->errors(),
         ], 422);
      } catch (Exception $e) {
         return response()->json([
            'message' => 'An error occurred while updating system settings',
            'error' => $e->getMessage(),
         ], 500);
      }
   }
}