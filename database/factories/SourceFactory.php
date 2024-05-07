<?php

namespace Database\Factories;

use App\Models\Srt;
use App\Models\Youtubevideo;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Source>
 */
class SourceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sourceable_id' => $this->faker->numberBetween(1, 100),
            'sourceable_type' => Arr::random([Srt::class, Youtubevideo::class]),
            //
        ];
    }
}
