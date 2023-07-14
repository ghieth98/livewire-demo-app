<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => fake()->colorName,
            'description' => fake()->text(20),
            'country_id' => rand(1, 20),

            'price' => rand(1000, 10000)
        ]);
        Product::create([
            'name' => fake()->colorName,
            'description' => fake()->text(20),
            'country_id' => rand(1, 20),
            'price' => rand(1000, 10000)
        ]);
        Product::create([
            'name' => fake()->colorName,
            'description' => fake()->text(20),
            'country_id' => rand(1, 20),
            'price' => rand(1000, 10000)
        ]);
        Product::create([
            'name' => fake()->colorName,
            'description' => fake()->text(20),
            'country_id' => rand(1, 20),
            'price' => rand(1000, 10000)
        ]);
        Product::create([
            'name' => fake()->colorName,
            'description' => fake()->text(20),
            'country_id' => rand(1, 20),
            'price' => rand(1000, 10000)
        ]);
        Product::create([
            'name' => fake()->colorName,
            'description' => fake()->text(20),
            'country_id' => rand(1, 20),
            'price' => rand(1000, 10000)
        ]);
        Product::create([
            'name' => fake()->colorName,
            'description' => fake()->text(20),
            'country_id' => rand(1, 20),
            'price' => rand(1000, 10000)
        ]);
        Product::create([
            'name' => fake()->colorName,
            'description' => fake()->text(20),
            'country_id' => rand(1, 20),
            'price' => rand(1000, 10000)
        ]);
        Product::create([
            'name' => fake()->colorName,
            'description' => fake()->text(20),
            'country_id' => rand(1, 20),
            'price' => rand(1000, 10000)
        ]);
        Product::create([
            'name' => fake()->colorName,
            'description' => fake()->text(20),
            'country_id' => rand(1, 20),
            'price' => rand(1000, 10000)
        ]);
        Product::create([
            'name' => fake()->colorName,
            'description' => fake()->text(20),
            'country_id' => rand(1, 20),
            'price' => rand(1000, 10000)
        ]);
        Product::create([
            'name' => fake()->colorName,
            'description' => fake()->text(20),
            'country_id' => rand(1, 20),
            'price' => rand(1000, 10000)
        ]);
        Product::create([
            'name' => fake()->colorName,
            'description' => fake()->text(20),
            'country_id' => rand(1, 20),
            'price' => rand(1000, 10000)
        ]);

    }
}
