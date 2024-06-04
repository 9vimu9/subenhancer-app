<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Core\Contracts\Apis\DefinitionSelectorApiInterface;
use App\DataObjects\Sentences\Sentence;
use App\Dtos\CorpusDto;
use App\Dtos\DefinitionDto;
use App\Dtos\DefinitionDtoCollection;
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
        $definitions = Definition::factory()->count(3)->create(['corpus_id' => $corpus->id]);
        $definitionDtoCollection = new DefinitionDtoCollection();
        $corpus->definitions->each(function (Definition $definition) use (&$definitionDtoCollection) {
            $definitionDtoCollection->add(new DefinitionDto($definition->id, $definition->corpus_id, $definition->definition));
        });
        $corpusDto = new CorpusDto($corpus->id, $corpus->word, $definitionDtoCollection);
        $actual = $service->findMostSuitableDefinitionId($sentence, $corpusDto, 0);
        $this->assertEquals($definitions->first()->id, $actual);

    }

    public function test_returns_null_when_no_definition_to_be_found(): void
    {
        $service = new DefinitionSelectorService(new MockDefinitionSelectorApi());
        $sentence = new Sentence('Sentence here');
        $corpus = Corpus::factory()->create();
        $definitionDtoCollection = new DefinitionDtoCollection();
        $corpusDto = new CorpusDto($corpus->id, $corpus->word, $definitionDtoCollection);
        $actual = $service->findMostSuitableDefinitionId($sentence, $corpusDto, 0);
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
