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
        $table->unsignedBigInteger('dish_id');
        $table->unsignedBigInteger('ingredient_id');
        $table->decimal('default_recipe_qty', 12, 4);
        $table->unsignedBigInteger('unit_id');
        $table->decimal('default_cost_per_unit', 12, 4)->default(0);
        $table->unsignedBigInteger('cost_unit_id');
        $table->decimal('default_wastage_qty', 12, 4)->default(0);
        $table->unsignedBigInteger('wastage_unit_id')->nullable();
        $table->decimal('default_wastage_sell_price', 12, 4)->default(0);
        $table->json('data')->nullable();
        $table->softDeletes();
        $table->timestamps();

        $table->foreign('dish_id')->references('id')->on('dishes')->onDelete('cascade');
        $table->foreign('ingredient_id')->references('id')->on('ingredients')->onDelete('cascade');
        $table->foreign('unit_id')->references('id')->on('units');
        $table->foreign('cost_unit_id')->references('id')->on('units');
        $table->foreign('wastage_unit_id')->references('id')->on('units');

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
