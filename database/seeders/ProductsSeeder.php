<?php

namespace Database\Seeders;

use App\Models\Product;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 100; $i++) {
            Product::create([
                'name' => Factory::create()->name(),
                'small_description' => Factory::create()->sentence(5),
                'long_description' => Factory::create()->sentence(100),
                'price' => Factory::create()->numberBetween($min = 1500, $max = 6000),
                'status' => Factory::create()->randomElement(['stock', 'rupture', 'recommande']),
            ]);
        }
    }
}
