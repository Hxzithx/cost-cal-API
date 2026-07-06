<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('overhead_costs', function (Blueprint $table) {
            $table->enum('cost_type', [
                'rent_lease',
                'utilities',
                'fuel',
                'transport',
                'equipment_machine',
                'insurance',
                'administration',
                'maintenance',
                'subcontract',
                'finance_charges',
                'other',
            ])->nullable()->after('dish_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('overhead_costs', function (Blueprint $table) {
            //
        });
    }
};
