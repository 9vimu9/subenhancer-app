<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\WordClassEnum;
use App\Models\Corpus;
use App\Services\Definitions\Definition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DefinitionTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_method(): void
    {
        $wordClass = WordClassEnum::NOUN;
        $stringDefinition = 'SOME DEF';
        $word = 'RANDOM WORD';
        $definition = new Definition($wordClass, $stringDefinition, $word);
        $corpus = Corpus::factory()->create();
        $definition->store($corpus->id);
        $this->assertDatabaseHas('definitions', [
            'definition' => $stringDefinition,
            'corpus_id' => $corpus->id,
            'word_class' => $wordClass->name,
        ]);

    }
}
