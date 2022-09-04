<?php

namespace Database\Seeders;

use App\Models\CategorieProduct;
use App\Models\SubCategorieProduct;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubCategorieProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = new Factory();
        for ($i = 0; $i < 10; $i++) {
            SubCategorieProduct::create([
                'name' => Factory::create()->name(),
                'categorie_product_id' => collect(CategorieProduct::all())->random()->id,
            ]);
        }
    }
}
