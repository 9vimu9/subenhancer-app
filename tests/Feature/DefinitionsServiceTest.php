<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Core\Contracts\Apis\DefinitionsApiInterface;
use App\DataObjects\Definitions\Definition;
use App\DataObjects\Definitions\DefinitionCollection;
use App\DataObjects\FilteredWords\FilteredWord;
use App\DataObjects\FilteredWords\FilteredWordCollection;
use App\Enums\WordClassEnum;
use App\Exceptions\CantFindDefinitionException;
use App\Models\Corpus;
use App\Services\DefinitionsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Mocks\MockDefinitionsApi;
use Tests\TestCase;

class DefinitionsServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_set_definitions_to_collection(): void
    {
        $service = new DefinitionsService(new MockDefinitionsApi());
        $wordWithDefinitions = 'word_with_definitions';
        $corpusWithDefinition = Corpus::factory()->create(['word' => strtolower($wordWithDefinitions)]);
        $definitionOfTheWordWithDefinition = \App\Models\Definition::factory()->create(['corpus_id' => $corpusWithDefinition->id]);

        $wordWithoutDefinitions = 'word_without_definitions';
        Corpus::factory()->create(['word' => strtolower($wordWithoutDefinitions)]);

        $collection = new FilteredWordCollection(
            new FilteredWord($wordWithoutDefinitions),
            new FilteredWord($wordWithDefinitions),
        );
        $actual = $service->setDefinitionsToCollection($collection);

        $wordWithDefinitionFilteredWord = new FilteredWord($wordWithDefinitions);
        $wordWithDefinitionFilteredWord->setDefinitions(
            new DefinitionCollection(
                new Definition(
                    WordClassEnum::fromName($definitionOfTheWordWithDefinition->word_class),
                    $definitionOfTheWordWithDefinition->definition,
                    $wordWithDefinitions
                )

            )
        );
        $wordWithoutDefinitionFilteredWord = new FilteredWord($wordWithoutDefinitions);
        $wordWithoutDefinitionFilteredWord->setDefinitions(
            new DefinitionCollection(
                new Definition(
                    MockDefinitionsApi::WORD_CLASS,
                    MockDefinitionsApi::DEFINITION,
                    $wordWithoutDefinitions
                )
            )
        );

        $expected = new FilteredWordCollection($wordWithDefinitionFilteredWord);
        $this->assertEquals($expected, $actual);
    }

    public function test_remove_filtered_word_from_the_collection_when_no_definition_is_available(): void
    {
        $service = new DefinitionsService(new class implements DefinitionsApiInterface
        {
            public function getDefinitions(string $word): DefinitionCollection
            {
                throw new CantFindDefinitionException();
            }

            public function wordClassMapper(string $wordClass): WordClassEnum
            {
                return WordClassEnum::NOUN;
            }
        });

        $filteredWordCollection = new FilteredWordCollection(
            new FilteredWord('random_word_1'),
            new FilteredWord('random_word_2')
        );
        $filteredWordCollection = $service->setDefinitionsToCollection($filteredWordCollection);
        $this->assertEquals(0, $filteredWordCollection->count());
    }

    public function test_processDefinitionsByCollection(): void
    {
        $corpus = Corpus::factory()->create(['word' => 'OLD_WORD']);
        Corpus::factory()->create(['word' => 'NEW_WORD']);
        $definitionsForTheWord = 3;
        \App\Models\Definition::factory()->count($definitionsForTheWord)->create(['corpus_id' => $corpus->id]);

        $collection = new FilteredWordCollection(
            new FilteredWord('OLD_WORD'),
            new FilteredWord('NEW_WORD'),
        );

        $service = new DefinitionsService(new class implements DefinitionsApiInterface
        {
            public function getDefinitions(string $word): DefinitionCollection
            {
                return new DefinitionCollection(
                    new Definition(WordClassEnum::NOUN, 'TEST DEFINITION', 'NEW_WORD'),
                );
            }

            public function wordClassMapper(string $wordClass): WordClassEnum
            {
                return WordClassEnum::NOUN;
            }
        });
        $actual = $service->processDefinitionsByCollection($collection);
        $this->assertDatabaseCount('definitions', $definitionsForTheWord + 1);
        $this->assertDatabaseHas('definitions', ['definition' => 'TEST DEFINITION']);
    }
}
