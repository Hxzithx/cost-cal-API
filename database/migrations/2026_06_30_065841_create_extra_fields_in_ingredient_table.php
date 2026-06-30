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
        Schema::table('ingredients', function (Blueprint $table) {
            $table->text('description')->nullable()->after('name');
            $table->unsignedBigInteger('category_id')->nullable()->after('description');
            $table->decimal('stock_qty', 12, 4)->default(0)->after('category_id');
            $table->unsignedBigInteger('stock_unit_id')->nullable()->after('stock_qty');
            $table->decimal('min_level_qty', 12, 4)->default(0)->after('stock_unit_id');
            $table->decimal('wastage_per_unit', 12, 4)->nullable()->after('min_level_qty');
            $table->decimal('cost_per_unit', 12, 4)->default(0)->after('wastage_per_unit');
            $table->unsignedBigInteger('cost_unit_id')->nullable()->after('cost_per_unit');
            $table->unsignedBigInteger('supplier_id')->nullable()->after('cost_unit_id');

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('restrict');
            $table->foreign('stock_unit_id')->references('id')->on('units')->onDelete('restrict');
            $table->foreign('cost_unit_id')->references('id')->on('units')->onDelete('restrict');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ingredients', function (Blueprint $table) {
            //
        });
    }
};
