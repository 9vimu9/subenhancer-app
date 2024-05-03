<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class YoutubevideoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'video_id' => $this->faker->firstNameMale(),
        ];
    }
}
