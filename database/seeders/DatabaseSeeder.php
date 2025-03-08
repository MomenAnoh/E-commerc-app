<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Categorie;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // إنشاء 10 مستخدمين
        User::factory(1)->create();

        // إنشاء 5 فئات وكل فئة تحتوي على 5 منتجات
        Categorie::factory(1)->create()->each(function ($category) {
            Product::factory(1)->create([
                'category_id' => $category->id
            ]);
        });
    }
}
