<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
           ProductsSeeder::class,
           CategorieProductSeeder::class,
           SubCategorieProductsSeeder::class,
           ShopsSeeder::class,
           CategorieShopSeeder::class
        ]);
    }
}
