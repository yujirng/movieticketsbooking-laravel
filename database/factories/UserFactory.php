<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'username' => $this->faker->userName,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // You can replace 'password' with any default password you want
            'phone' => substr($this->faker->phoneNumber, 0, 15),
            'birthday' => $this->faker->date,
            'image' => 'default.jpg', // Default image file name
            'gender' => $this->faker->randomElement([0, 1]), // Randomly generate gender (0: male, 1: female)
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
