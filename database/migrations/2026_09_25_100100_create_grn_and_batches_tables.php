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
        Schema::create('grn_records', function (Blueprint $table) {
            $table->id();
            $table->string('grn_no')->unique();
            $table->string('po_no')->nullable();
            $table->string('ref_no')->nullable();
            $table->boolean('is_consignment')->default(false);
            $table->string('grn_date');
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->string('supplier_name')->default('');
            $table->string('cost_centre')->nullable();
            $table->string('po_status')->default('Pending');
            $table->string('payment_term')->default('CASH');
            $table->unsignedBigInteger('location_id')->nullable();
            $table->string('location_name')->nullable();
            $table->json('line_items')->nullable();
            $table->json('financials')->nullable();
            $table->string('status')->default('posted');
            $table->timestamps();
        });

        Schema::create('grn_batches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('master_ingredient_id')->nullable();
            $table->string('grn_number');
            $table->string('batch_number');
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->string('supplier_name')->nullable();
            $table->string('received_date');
            $table->string('expiry_date')->nullable();
            $table->double('initial_qty')->default(0);
            $table->double('remaining_qty')->default(0);
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->double('unit_cost')->default(0);
            $table->unsignedBigInteger('location_id')->nullable();
            $table->string('location_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grn_batches');
        Schema::dropIfExists('grn_records');
    }
};
