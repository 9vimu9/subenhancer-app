<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Corpus;
use App\Models\Definition;
use App\Models\Sentence;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Captionword>
 */
class CaptionwordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_in_sentence' => $this->faker->randomDigit(),
            'sentence_id' => Sentence::factory(),
            'corpus_id' => Corpus::factory(),
            'definition_id' => Definition::factory(),

        ];
    }
}
