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
        Schema::create('labor_costs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dish_id');
            $table->string('role_name');
            $table->decimal('monthly_salary', 12, 2);
            $table->decimal('monthly_hours', 12, 2);
            $table->decimal('prep_time_minutes', 12, 2);
            $table->json('data')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('dish_id')
                ->references('id')->on('dishes')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('labor_costs');
    }
};
