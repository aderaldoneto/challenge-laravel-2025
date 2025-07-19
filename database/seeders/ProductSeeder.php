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
        $products = ['Pizza', 'Sushi', 'Yakisoba', 'Hamburguer', 'Hot Dog', 'Salada', 'Bolo', 'Sorvete'];

        $categories = Category::all();

        if ($categories->isEmpty()) {
            $this->command->warn('Nenhuma categoria encontrada. Execute o CategorySeeder antes.');
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
