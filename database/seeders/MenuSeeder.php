<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = ['Desayuno', 'Almuerzo', 'Merienda', 'Cena', ];

        $products = Product::all();

        if ($products->isEmpty()) {
            $this->command->warn('No se encontró ningún producto. Ejecute el ProductSeeder antes.');
            return;
        }

        foreach ($menus as $name) {
            $menu = Menu::create([
                'name' => $name,
            ]);

            $slugBase = Str::slug($name);
            $menu->slug = "{$slugBase}-{$menu->id}";
            $menu->save();

            $menu->products()
                ->attach($products->random(rand(1, 3))
                ->pluck('id'));
        }
    }
}
