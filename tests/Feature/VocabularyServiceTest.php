<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\VocabularyEnum;
use App\Models\Captionword;
use App\Models\Definition;
use App\Models\Duration;
use App\Models\Sentence;
use App\Models\Source;
use App\Models\User;
use App\Models\Vocabulary;
use App\Services\VocabularyService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VocabularyServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_vocabularies_table_has_composite_key_with_definitions_id_and_user_id(): void
    {
        $user = User::factory()->create();
        $definition = Definition::factory()->create();
        Vocabulary::query()->insertOrIgnore(['user_id' => $user->id, 'definition_id' => $definition->id]);
        Vocabulary::query()->insertOrIgnore(['user_id' => $user->id, 'definition_id' => $definition->id]);
        $this->assertDatabaseCount('vocabularies', 1);

    }

    public function test_updateVocabularyBySource_method(): void
    {
        $source = Source::factory()->create();
        $source->each(function (Source $source) {
            $source->durations()
                ->saveMany(
                    Duration::factory()
                        ->count(20)
                        ->create(['source_id' => $source])
                        ->each(function (Duration $duration) {
                            $duration->sentences()
                                ->saveMany(
                                    Sentence::factory()
                                        ->count(2)
                                        ->create(['duration_id' => $duration->id])
                                        ->each(function (Sentence $sentence) {
                                            $sentence
                                                ->filteredwords()
                                                ->saveMany(
                                                    Captionword::factory()
                                                        ->count(1)
                                                        ->create([
                                                            'sentence_id' => $sentence->id,
                                                        ])
                                                );
                                        })
                                );

                        })
                );
        });
        $user = User::factory()->create();
        $this->actingAs($user);
        $definitionOne = Definition::all()->first();
        $definitionTwo = Definition::all()->last();
        Vocabulary::factory()->create([
            'user_id' => $user->id,
            'definition_id' => $definitionOne->id,
            'vocabulary_type' => VocabularyEnum::MARKED_AS_KNOWN->name,
        ]);

        Vocabulary::factory()->create([
            'user_id' => $user->id,
            'definition_id' => $definitionTwo->id,
            'vocabulary_type' => VocabularyEnum::MARKED_AS_KNOWN->name,
        ]);

        $this->assertDatabaseMissing('vocabularies', [
            'vocabulary_type' => VocabularyEnum::HAVE_NOT_SPECIFIED->name,
        ]);
        (new VocabularyService())->updateVocabularyBySource($source->id);
        $this->assertDatabaseHas('vocabularies', [
            'vocabulary_type' => VocabularyEnum::HAVE_NOT_SPECIFIED->name,
        ]);

    }
}
