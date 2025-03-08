<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Categorie;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 10, 500), // سعر بين 10 و 500
            'image' => 'images/default-product.png',
            'category_id' => Categorie::inRandomOrder()->first()->id ?? 1, // اختيار فئة عشوائية
        ];
    }
}
