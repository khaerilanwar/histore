<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $price = fake()->numberBetween(1, 17) * 1000;
        return [
            'barcode' => fake()->ean13(),
            'name' => fake()->unique()->words(
                fake()->numberBetween(2, 5),
                true
            ),
            'price' => $price,
            'price_buy' => 0.85 * $price,
            'category_id' => fake()->randomElement(Category::pluck('id')->toArray()),
            'images' =>
            implode(
                " -- ",
                fake()->randomElements(
                    array_map(function ($i) {
                        return "image$i.jpg";
                    }, range(0, 20)),
                    3
                )
            )
        ];
    }
}
