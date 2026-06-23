<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('unit_conversation', 'unit_conversions');
    }

    public function down(): void
    {
        Schema::rename('unit_conversions', 'unit_conversation');
    }
};