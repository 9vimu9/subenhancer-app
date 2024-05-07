<?php

namespace Database\Factories;

use App\Models\Duration;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sentence>
 */
class SentenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order' => $this->faker->randomDigit(),
            'sentence' => $this->faker->sentence(),
            'duration_id' => function () {
                return Duration::factory()->create()->id;
            },
        ];
    }
}
