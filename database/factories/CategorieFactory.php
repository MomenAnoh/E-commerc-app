<?php

namespace Database\Factories;

use App\Models\Categorie;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Categorie>
 */
class CategorieFactory extends Factory
{
    protected $model = Categorie::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'image' => 'images/default-category.png', // صورة افتراضية
        ];
    }
}
