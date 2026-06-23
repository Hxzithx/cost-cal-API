<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Dish;
use Illuminate\Database\Seeder;

class DishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mainCourse = Category::where('name', 'Main Course')->first();
        $appetizer = Category::where('name', 'Appetizers')->first();
        $dessert = Category::where('name', 'Desserts')->first();

        $dishes = [
            [
                'name' => 'Chicken Fried Rice',
                'description' => 'Classic fried rice with chicken, eggs, and vegetables seasoned with soy sauce.',
                'category_id' => $mainCourse ? $mainCourse->id : null,
            ],
            [
                'name' => 'Garlic Bread',
                'description' => 'Toasted bread topped with garlic, butter, and parsley.',
                'category_id' => $appetizer ? $appetizer->id : null,
            ],
            [
                'name' => 'Chocolate Lava Cake',
                'description' => 'Rich chocolate cake with a warm liquid chocolate center.',
                'category_id' => $dessert ? $dessert->id : null,
            ],
        ];

        foreach ($dishes as $dish) {
            Dish::create($dish);
        }
    }
}
