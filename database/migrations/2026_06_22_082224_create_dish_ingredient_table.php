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
        Schema::create('dish_ingredient', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dish_id')->constrained('dishes')->onDelete('cascade');
            $table->unsignedBigInteger('ingredient_id')->constrained('ingredients')->onDelete('cascade');
            $table->decimal('quantity', 12, 4);
            $table->unsignedBigInteger('unit_id')->constrained('units')->onDelete('restrict');
            $table->decimal('wastage_quantity', 12, 4)->default(0.0000);
            $table->unsignedBigInteger('wastage_unit_id')->nullable()->constrained('units')->onDelete('restrict');
            $table->timestamps();

            $table->unique(['dish_id', 'ingredient_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dish_ingredient');
    }
};
