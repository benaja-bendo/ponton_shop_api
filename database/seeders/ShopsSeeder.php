<?php

namespace Database\Seeders;

use App\Models\Shop;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShopsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 100; $i++) {
            Shop::create([
                'name' => Factory::create()->name(),
                'description' => Factory::create()->sentence(50),
                'address' => Factory::create()->address(),
                'city' => Factory::create()->city(),
                'postal_code' => Factory::create()->postcode(),
                'web' => "http://" . Factory::create()->name() . ".com",
                'email' => Factory::create()->email(),
                'telephone' => Factory::create()->phoneNumber(),
            ]);
        }
    }
}
