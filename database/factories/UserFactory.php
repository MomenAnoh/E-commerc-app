<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'username' => $this->faker->userName(),
            'mobile' => $this->faker->unique()->phoneNumber(),
            'email' => 'momennoh123aa@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('20042004'), // كلمة مرور افتراضية
            'remember_token' => \Str::random(10),
        ];
    }
}
