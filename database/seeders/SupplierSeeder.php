<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            ['name' => 'Heritage Grains', 'external_id' => 'SUP-HG-01', 'is_active' => true],
            ['name' => 'Meat Masters', 'external_id' => 'SUP-MM-02', 'is_active' => true],
            ['name' => 'City Greens', 'external_id' => 'SUP-CG-03', 'is_active' => true],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}