<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\WordClassEnum;
use App\Models\Corpus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Definition>
 */
class DefinitionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $wordClasses = array_column(WordClassEnum::cases(), 'name');
        $wordClass = $wordClasses[array_rand($wordClasses)];

        return [
            'definition' => $this->faker->sentence(),
            'corpus_id' => Corpus::factory(),
            'word_class' => $wordClass,
        ];
    }
}
