<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Livre>
 */
class LivreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titre' => $this->faker->sentence,
            'description' => $this->faker->text(200),
            'image_url' => $this->faker->imageUrl,
            'stock' => $this->faker->numberBetween(1, 100),
            'rating' => $this->faker->numberBetween(1, 5),
        ];
    }
}
