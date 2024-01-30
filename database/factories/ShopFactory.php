<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ShopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'category_id' => fake()->numberBetween(1,36),
            'name' => fake()->lastKanaName(),
            'description' => fake()->realText(50,5),
            'min_price' => fake()->numberBetween(500,3000),
            'max_price' => fake()->numberBetween(4000,30000),
            'opening_time' => fake()->time(),
            'closing_time' => fake()->time(),
            'regular_holiday' => fake()->dayOfWeek(),
            'postal_code' => fake()->postcode(),
            'address' => fake()->streetAddress()
        ];
    }
}
