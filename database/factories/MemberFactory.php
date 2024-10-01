<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = fake()->randomElement(['male', 'female']);

        return [
            'name' => fake()->name($gender),
            'no_hp' => '08' . fake()->randomElement([1, 2, 3, 5, 7, 8, 9]) . fake()->randomNumber(9),
            'gender' => $gender,
            'point' => 0
        ];
    }
}
