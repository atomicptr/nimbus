<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'content' => fake()->paragraph,
            'is_draft' => fake()->boolean(10),
            'promo_image' => fake()->imageUrl,
            'publish_date' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
