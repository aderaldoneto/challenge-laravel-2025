<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = ['Pizza', 'Sushi', 'Yakisoba', 'Hamburguesa', 'Perro caliente', 'Ensalada', 'Pastel', 'Helado'];

        $categories = Category::all();

        if ($categories->isEmpty()) {
            $this->command->warn('No se encontró ninguna categoría. Ejecute el CategorySeeder primero.');
            return;
        }

        foreach ($products as $name) {
            $category = $categories->random();

            Product::updateOrCreate(
                ['name' => $name],
                [
                    'description' => fake()->sentence(),
                    'price' => fake()->numberBetween(100, 10000),
                    'category_id' => $category->id,
                ]
            );
        }
    }
}
