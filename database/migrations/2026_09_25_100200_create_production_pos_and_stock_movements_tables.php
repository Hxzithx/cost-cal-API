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
        Schema::create('production_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dish_id')->nullable();
            $table->string('dish_name');
            $table->double('produced_qty');
            $table->double('total_cost')->default(0);
            $table->string('produced_at');
            $table->json('consumed_batches')->nullable();
            $table->timestamps();
        });

        Schema::create('pos_daily_sales', function (Blueprint $table) {
            $table->id();
            $table->string('sale_date');
            $table->unsignedBigInteger('dish_id')->nullable();
            $table->string('dish_name');
            $table->double('sold_qty');
            $table->double('unit_price')->default(0);
            $table->double('total_revenue')->default(0);
            $table->double('produced_qty_today')->nullable();
            $table->double('variance_qty')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->string('movement_type'); // OPEN_STOCK, ADJUSTMENT, GRN, TRN, PRN, PO, POS_SALE, PRODUCTION_STAGE
            $table->string('reference_no');
            $table->unsignedBigInteger('source_location_id')->nullable();
            $table->string('source_location_name')->nullable();
            $table->unsignedBigInteger('destination_location_id')->nullable();
            $table->string('destination_location_name')->nullable();
            $table->unsignedBigInteger('ingredient_id')->nullable();
            $table->string('ingredient_name');
            $table->string('batch_no')->nullable();
            $table->double('qty');
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->string('unit_symbol')->default('');
            $table->double('unit_cost')->default(0);
            $table->double('total_cost')->default(0);
            $table->string('movement_date');
            $table->string('reason')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default('completed');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
        Schema::dropIfExists('pos_daily_sales');
        Schema::dropIfExists('production_logs');
    }
};
