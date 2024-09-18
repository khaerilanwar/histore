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
        return [
            'barcode' => fake()->ean13(),
            'name' => fake()->words(
                fake()->numberBetween(2, 5),
                true
            ),
            'stock' => fake()->numberBetween(1, 100),
            'price' => fake()->numberBetween(5, 27) * 1000,
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
