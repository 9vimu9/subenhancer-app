<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\EnhancementEnum;
use App\Models\Source;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enhancement>
 */
class EnhancementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statusEnum = array_column(EnhancementEnum::cases(), 'name');
        $status = $statusEnum[array_rand($statusEnum)];

        return [
            'uuid' => $this->faker->uuid(),
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'user_id' => User::factory(),
            'source_id' => Source::factory(),
            'status' => $status,
        ];
    }
}
