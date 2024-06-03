<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Core\Contracts\Apis\DefinitionSelectorApiInterface;
use App\DataObjects\Sentences\Sentence;
use App\Models\Corpus;
use App\Models\Definition;
use App\Services\DefinitionSelectorService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DefinitionSelectorServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_findMostSuitableDefinitionId(): void
    {
        $service = new DefinitionSelectorService(new MockDefinitionSelectorApi());
        $sentence = new Sentence('Sentence here');
        $corpus = Corpus::factory()->create();
        $definictions = Definition::factory()->count(3)->create(['corpus_id' => $corpus->id]);
        $wordData = [
            'id' => $corpus->id,
            'word' => $corpus->word,
            'definitions' => $corpus->definitions->toArray(),
        ];
        $actual = $service->findMostSuitableDefinitionId($sentence, $wordData, 0);
        $this->assertEquals($definictions->first()->id, $actual);

    }

    public function test_returns_null_when_no_definition_to_be_found(): void
    {
        $service = new DefinitionSelectorService(new MockDefinitionSelectorApi());
        $sentence = new Sentence('Sentence here');
        $corpus = Corpus::factory()->create();
        $wordData = [
            'id' => $corpus->id,
            'word' => $corpus->word,
            'definitions' => $corpus->definitions->toArray(),
        ];
        $actual = $service->findMostSuitableDefinitionId($sentence, $wordData, 0);
        $this->assertNull($actual);

    }
}

class MockDefinitionSelectorApi implements DefinitionSelectorApiInterface
{
    public function pickADefinitionBasedOnContext(string $context, array $definitionArray, string $word, int $orderInTheContext): string
    {
        return $definitionArray[0];
    }
}
