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
        Schema::create('unit_conversation', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_unit_id');
            $table->unsignedBigInteger('child_unit_id');
            $table->decimal('factor', 12, 4);
            $table->json('data')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('parent_unit_id')
                ->references('id')->on('units')
                ->onDelete('cascade');

            $table->foreign('child_unit_id')
                ->references('id')->on('units')
                ->onDelete('cascade');

            $table->unique(['parent_unit_id', 'child_unit_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_conversation');
    }
};
