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
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('cost_price', 12, 4);
            $table->unsignedBigInteger('purchase_unit_id')->constrained('units')->onDelete('restrict');
            $table->decimal('wastage_sell_price', 12, 4)->default(0.0000);
            $table->unsignedBigInteger('wastage_sell_unit_id')->nullable()->constrained('units')->onDelete('restrict');
            $table->json('data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredients');
    }
};
