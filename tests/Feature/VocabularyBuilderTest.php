<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Dtos\DtoCollection;
use App\Models\Captionword;
use App\Models\Corpus;
use App\Models\Definition;
use App\Models\Duration;
use App\Models\Sentence;
use App\Models\Source;
use App\Models\User;
use App\Models\Vocabulary;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VocabularyBuilderTest extends TestCase
{
    use RefreshDatabase;

    public function test_getUserVocabularyBySource_method(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $source = Source::factory()->create();
        $duration = Duration::factory()->create(['source_id' => $source->id]);
        $sentence = Sentence::factory()->create(['duration_id' => $duration->id]);

        $corpus = Corpus::factory()->create();
        $definition = Definition::factory()->create(['corpus_id' => $corpus->id]);

        $captionword = Captionword::factory()->create(['definition_id' => $definition->id, 'sentence_id' => $sentence->id]);
        $vocabulary = Vocabulary::factory()->create(['definition_id' => $definition->id, 'user_id' => $user->id]);

        $expected = new DtoCollection(
            $vocabulary->toDto(),
        );
        $this->assertEquals(
            $expected,
            Vocabulary::query()->getUserVocabularyBySource($source->id, $user->id)
        );

    }
}
