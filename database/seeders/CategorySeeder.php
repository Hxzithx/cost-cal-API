<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Appetizers', 'is_active' => true],
            ['name' => 'Main Course', 'is_active' => true],
            ['name' => 'Desserts', 'is_active' => true],
            ['name' => 'Beverages', 'is_active' => true],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
