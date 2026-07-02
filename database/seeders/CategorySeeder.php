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
            ['name' => 'Appetizers', 'color' => 'Red', 'is_active' => true],
            ['name' => 'Main Course', 'color' => 'Blue', 'is_active' => true],
            ['name' => 'Desserts', 'color' => 'Yellow', 'is_active' => true],
            ['name' => 'Beverages', 'color' => 'Indigo', 'is_active' => true],
        ];

        foreach ($categories as $category) {
            // Create the category
            $model = Category::create($category);

            // Build snapshot of attributes
            $attributes = $model->getAttributes();
            unset($attributes['created_at'], $attributes['updated_at'], $attributes['deleted_at']);

            // Backfill the data column explicitly
            $model->updateQuietly(['data' => $attributes]);
        }
    }
}
