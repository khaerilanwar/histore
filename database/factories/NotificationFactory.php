<?php

namespace Database\Factories;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'id' => Str::random(24),
            'title' => fake()->words(asText: true),
            'description' => fake()->sentences(nb: 2, asText: true),
            'readable' => fake()->randomElement([true, false]),
        ];
    }

    public function public(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'public',
        ]);
    }

    public function private(): static
    {
        $shops = Shop::all()->pluck('id');
        return $this->state(fn(array $attributes) => [
            'status' => 'private',
            'shop_id' => fake()->randomElement($shops)
        ]);
    }
}
