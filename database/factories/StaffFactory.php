<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Staff>
 */
class StaffFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nik' => fake()->unique()->randomNumber(8, true) . fake()->unique()->randomNumber(8, true),
            'name' => fake()->name(),
            'ttl' => fake()->city() . ', ' . fake()->date('d F Y', '-14 years'),
            'email' => fake()->unique()->freeEmail(),
            'no_hp' => '08' . fake()->randomElement([1, 2, 3, 5, 7, 8, 9]) . fake()->randomNumber(9),
            'alamat' => fake()->address(),
            'salary' => 2104000
        ];
    }
}
