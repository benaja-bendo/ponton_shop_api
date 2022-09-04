<?php

namespace Database\Seeders;

use App\Models\CategorieProduct;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorieProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            CategorieProduct::create([
                'name' => Factory::create()->name(),
            ]);
        }
    }
}
