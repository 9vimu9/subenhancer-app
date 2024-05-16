<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Exceptions\DefinitionAlreadyExistException;
use App\Exceptions\WordNotInCorpusException;
use App\Models\Corpus;
use App\Services\Definitions\Definition;
use App\Services\Definitions\DefinitionCollection;
use App\Services\DefinitionsService;
use App\Services\FilteredWords\FilteredWord;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Mocks\MockDefinitionsApi;
use Tests\TestCase;

class DefinitionsServiceTest extends TestCase
{
    use RefreshDatabase;

    #[DataProvider('provideInputs')]
    public function test_set_definitions(
        DefinitionsService $service,
        string $wordToDefine,
        DefinitionCollection $definitionCollection,
    ): void {
        $word = $service->setDefinitions(new FilteredWord($wordToDefine));
        $this->assertEquals($definitionCollection, $word->getDefinitions());
    }

    #[DataProvider('provideInputs')]
    public function test_storeDefinitions(
        DefinitionsService $service,
        string $word,
        DefinitionCollection $definitionCollection,
        FilteredWord $filteredWord,

    ): void {
        Corpus::factory()->create(['word' => $word]);
        $service->storeDefinitions($filteredWord);
        $this->assertDatabaseHas('definitions', ['definition' => MockDefinitionsApi::DEFINITION]);

    }

    #[DataProvider('provideInputs')]
    public function test_exception_is_thrown_when_definition_does_exist(
        DefinitionsService $service,
        string $word,
        DefinitionCollection $definitionCollection,
        FilteredWord $filteredWord,
    ): void {
        $corpus = Corpus::factory()->create(['word' => $word]);
        \App\Models\Definition::factory()->create(['corpus_id' => $corpus->id]);
        $this->expectException(DefinitionAlreadyExistException::class);
        $service->storeDefinitions($filteredWord);

    }

    #[DataProvider('provideInputs')]
    public function test_exception_is_thrown_when_word_does_not_exist_in_the_database(
        DefinitionsService $service,
        string $word,
        DefinitionCollection $definitionCollection,
        FilteredWord $filteredWord,
    ): void {
        $this->expectException(WordNotInCorpusException::class);
        $service->storeDefinitions($filteredWord);

    }

    public static function provideInputs(): array
    {
        $service = new DefinitionsService(new MockDefinitionsApi());
        $word = 'random_word';
        $definition = new Definition(
            MockDefinitionsApi::WORD_CLASS,
            MockDefinitionsApi::DEFINITION,
            $word
        );
        $definitionCollection = new DefinitionCollection();
        $definitionCollection->add($definition);

        $filteredWord = new FilteredWord($word);
        $filteredWord->setDefinitions($definitionCollection);

        return [[
            $service,
            $word,
            $definitionCollection,
            $filteredWord,
        ]];

    }
}
