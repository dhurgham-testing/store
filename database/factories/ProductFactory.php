<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\ProductStatus;
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
            'category_id' => Category::factory(),
            'brand_id' => Brand::factory(),
            'name' => fake()->words(3, true),
            'description' => fake()->paragraph(),
            'cost' => fake()->randomFloat(2, 10, 1000),
            'price' => fake()->randomFloat(2, 20, 2000),
            'stock' => fake()->numberBetween(0, 100),
            'status' => ProductStatus::PUBLISHED,
        ];
    }

    /**
     * Indicate that the product is a draft.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => ProductStatus::DRAFT,
        ]);
    }

    /**
     * Indicate that the product is out of stock.
     */
    public function outOfStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'stock' => 0,
        ]);
    }
}
