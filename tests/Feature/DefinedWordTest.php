<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\DataObjects\DefinedWords\DefinedWord;
use App\Exceptions\IncompatibleVocabularyAndCaptionwordProvidedException;
use App\Models\Captionword;
use App\Models\Corpus;
use App\Models\Definition;
use App\Models\Vocabulary;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DefinedWordTest extends TestCase
{
    use RefreshDatabase;

    public function test_throws_exception_if_params_ara_incompatible(): void
    {
        $definitionForVocabulary = Definition::factory()->create();
        $definitionForCaptionword = Definition::factory()->create();
        $vocabulary = Vocabulary::factory()->create(['definition_id' => $definitionForVocabulary->id]);
        $captionword = Captionword::factory()->create(['definition_id' => $definitionForCaptionword->id]);
        $this->expectException(IncompatibleVocabularyAndCaptionwordProvidedException::class);
        new DefinedWord($vocabulary, $captionword);
    }

    public function test_getDefinition_method(): void
    {

        $definition = Definition::factory()->create();
        $vocabulary = Vocabulary::factory()->create(['definition_id' => $definition->id]);
        $captionword = Captionword::factory()->create(['definition_id' => $definition->id]);
        $this->assertEquals(
            $definition->definition,
            (new DefinedWord($vocabulary, $captionword))->getDefinition()
        );
    }

    public function test_getWord_method(): void
    {
        $corpus = Corpus::factory()->create();
        $definition = Definition::factory()->create(['corpus_id' => $corpus->id]);
        $vocabulary = Vocabulary::factory()->create(['definition_id' => $definition->id]);
        $captionword = Captionword::factory()->create(['definition_id' => $definition->id]);
        $this->assertEquals(
            $corpus->word,
            (new DefinedWord($vocabulary, $captionword))->getWord()
        );
    }

    public function test_getCorpusId_method(): void
    {
        $corpus = Corpus::factory()->create();
        $definition = Definition::factory()->create(['corpus_id' => $corpus->id]);
        $vocabulary = Vocabulary::factory()->create(['definition_id' => $definition->id]);
        $captionword = Captionword::factory()->create(['definition_id' => $definition->id]);

        $this->assertEquals(
            $corpus->id,
            (new DefinedWord($vocabulary, $captionword))->getCorpusId()
        );
    }
}
