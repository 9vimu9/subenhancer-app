<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\VocabularyEnum;
use App\Models\Definition;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vocabulary>
 */
class VocabularyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $vocabularyTypes = array_column(VocabularyEnum::cases(), 'name');
        $vocabularyType = $vocabularyTypes[array_rand($vocabularyTypes)];

        return [
            'user_id' => User::factory(),
            'definition_id' => Definition::factory(),
            'vocabulary_type' => $vocabularyType,

        ];
    }
}
