<?php

namespace Database\Seeders;

use App\Models\CategorieShop;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorieShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 5; $i++) {
            CategorieShop::create([
                'name' => Factory::create()->name(),
            ]);
        }
    }
}
