<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\DataObjects\DefinedWords\DefinedWord;
use App\Models\Captionword;
use App\Models\Corpus;
use App\Models\Definition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DefinedWordTest extends TestCase
{
    use RefreshDatabase;

    public function test_getDefinition_method(): void
    {

        $definition = Definition::factory()->create();
        $captionword = Captionword::factory()->create(['definition_id' => $definition->id]);
        $this->assertEquals(
            $definition->definition,
            (new DefinedWord($captionword))->getDefinition()
        );
    }

    public function test_getWord_method(): void
    {
        $corpus = Corpus::factory()->create();
        $definition = Definition::factory()->create(['corpus_id' => $corpus->id]);
        $captionword = Captionword::factory()->create(['definition_id' => $definition->id]);
        $this->assertEquals(
            $corpus->word,
            (new DefinedWord($captionword))->getWord()
        );
    }

    public function test_getCorpusId_method(): void
    {
        $corpus = Corpus::factory()->create();
        $definition = Definition::factory()->create(['corpus_id' => $corpus->id]);
        $captionword = Captionword::factory()->create(['definition_id' => $definition->id]);

        $this->assertEquals(
            $corpus->id,
            (new DefinedWord($captionword))->getCorpusId()
        );
    }
}
