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
use App\Services\DefinitionsService;
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
    public function test_set_definitions_to_collection(
        DefinitionsService $service,
        string $word,
        DefinitionCollection $definitionCollection,
    ): void {
        $filteredWordCollection = new FilteredWordCollection();
        $filteredWordCollection->add(new FilteredWord($word));
        $filteredWordCollection = $service->setDefinitionsToCollection($filteredWordCollection);
        $this->assertEqualsCanonicalizing($definitionCollection, $filteredWordCollection->getIterator()->current()->getDefinitions());

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
