<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
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
            'name' => $this->faker->words(3, true),
            'price' => $this->faker->randomFloat(2, 100, 50000),
            'quantity' => $this->faker->numberBetween(0, 100),
            'brand_id' => \App\Models\Brand::inRandomOrder()->first()?->id ?? 1,
            'subcategory_id' => \App\Models\Subcategory::inRandomOrder()->first()?->id ?? 1,
            'category_id' => \App\Models\Category::inRandomOrder()->first()?->id ?? 1,
        ];
    }
}
