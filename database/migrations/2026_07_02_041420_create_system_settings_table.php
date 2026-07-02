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
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('currency_symbol')->default('Rs.');
            $table->decimal('default_wastage_margin', 8, 2)->default(0);
            $table->decimal('standard_labor_hours_per_month', 8, 2)->default(208);
            $table->enum('pricing_calculation_method', ['margin', 'markup'])->default('margin');
            $table->decimal('target_gross_margin', 8, 2)->default(70);
            $table->json('data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};
