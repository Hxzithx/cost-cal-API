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
            $table->unsignedBigInteger('parent_unit_id')->constrained('units')->onDelete('cascade');
            $table->unsignedBigInteger('child_unit_id')->constrained('units')->onDelete('cascade');
            $table->decimal('factor', 12, 4);
            $table->timestamps();
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
