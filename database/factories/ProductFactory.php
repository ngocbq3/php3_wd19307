<?php

namespace Database\Factories;

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
            'name' => fake()->text(30),
            'image' => fake()->imageUrl(),
            'description' => fake()->paragraph(),
            'price' => rand(5, 100),
            'stock' => rand(0, 1000),
            'category_id' => rand(1, 4),
        ];
    }
}
