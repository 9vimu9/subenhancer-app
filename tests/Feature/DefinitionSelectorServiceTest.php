<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Core\Contracts\Apis\DefinitionSelectorApiInterface;
use App\Exceptions\NoCandidateDefinitionsAvailabletoChooseException;
use App\Models\Captionword;
use App\Models\Corpus;
use App\Models\Definition;
use App\Models\Sentence;
use App\Services\DefinitionSelectorService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DefinitionSelectorServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_updateFilteredWordDefinition(): void
    {
        $service = new DefinitionSelectorService(new MockDefinitionSelectorApi());

        $corpus = Corpus::factory()->create();
        Definition::factory()->count(2)->create(['corpus_id' => $corpus->id]);
        $expectedDefinition = Definition::factory()->create(['corpus_id' => $corpus->id, 'definition' => 'STATIC DEFINITION']);
        $sentence = Sentence::factory()->create();
        $filteredWord = Captionword::factory()->create([
            'sentence_id' => $sentence->id,
            'definition_id' => null,
        ]);
        $service->updateFilteredWordDefinition(
            $filteredWord->id,
            new \App\DataObjects\Sentences\Sentence('sen'),
            $corpus->id,
            $filteredWord->order_in_sentence,

        );
        $this->assertEquals(
            $expectedDefinition->id,
            Captionword::query()->find($filteredWord->id)->definition_id
        );

    }

    public function test_throw_exception_when_no_candidate_definitions_are_not_available(): void
    {
        $service = new DefinitionSelectorService(new MockDefinitionSelectorApi());

        $corpus = Corpus::factory()->create();
        $sentence = Sentence::factory()->create();
        $filteredWord = Captionword::factory()->create([
            'sentence_id' => $sentence->id,
            'definition_id' => null,
        ]);
        $this->expectException(NoCandidateDefinitionsAvailabletoChooseException::class);
        $service->updateFilteredWordDefinition(
            $filteredWord->id,
            new \App\DataObjects\Sentences\Sentence('sen'),
            $corpus->id,
            $filteredWord->order_in_sentence,

        );

    }
}

class MockDefinitionSelectorApi implements DefinitionSelectorApiInterface
{
    public function pickADefinitionBasedOnContext(string $context, array $definitionArray, string $word, int $orderInTheContext): string
    {
        return 'STATIC DEFINITION';
    }
}
