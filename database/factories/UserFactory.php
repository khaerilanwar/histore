<?php

namespace Database\Factories;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'nik' => fake()->randomNumber(8, true),
            'email' => fake()->unique()->freeEmail(),
            'no_hp' => '08' . fake()->randomElement([1, 2, 3, 5, 7, 8, 9]) . fake()->randomNumber(9),
            'alamat' => fake()->address(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => fake()->randomElement([1, 2]),
            'status' => 'active'
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function cashier(): static
    {
        return $this->state(fn(array $attributes) => [
            'role' => 2,
            'shop_id' => fake()->randomElement(Shop::all()->pluck('id')),
        ]);
    }

    public function admin(): static
    {
        return $this->state(fn(array $attributes) => [
            'role' => 1,
        ]);
    }
}
