<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Source;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Duration>
 */
class DurationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'start_time_in_millis' => $this->faker->randomDigit(),
            'end_time_in_millis' => $this->faker->randomDigit(),
            'source_id' => function () {
                return Source::factory()->create()->id;
            },
        ];
    }
}
