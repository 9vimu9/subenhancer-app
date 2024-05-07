<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\WordClassEnum;
use App\Models\Corpus;
use App\Services\FilteredWords\FilteredWord;
use App\Services\FilteredWords\FilteredWordCollection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Mocks\MockDefinitionsApi;
use Tests\TestCase;

class FilteredWordCollectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_to_array_method(): void
    {
        $filteredWordOne = new FilteredWord('filtered word 1');
        $filteredWordTwo = new FilteredWord('filtered word 2');
        $expected = [$filteredWordOne, $filteredWordTwo];
        $filteredWordCollection = new FilteredWordCollection();
        $filteredWordCollection->addFilteredWord($filteredWordOne);
        $filteredWordCollection->addFilteredWord($filteredWordTwo);
        $this->assertEqualsCanonicalizing($expected, $filteredWordCollection->toArray());
    }

    public function test_storeNewFilteredWordsDefinitions(): void
    {
        $word = 'Hello';
        $filteredWord = new FilteredWord($word);
        $collection = new FilteredWordCollection();
        $collection->addFilteredWord($filteredWord);
        $collection->storeNewFilteredWordsDefinitions(new MockDefinitionsApi());
        $this->assertDatabaseHas('corpuses', ['word' => $word]);
        $this->assertDatabaseHas('definitions', [
            'definition' => '"Hello!" or an equivalent greeting.',
            'word_class' => WordClassEnum::NOUN->name,
        ]);

    }

    public function test_ignore_storing_definitions_for_exiting_words(): void
    {
        $word = 'Hello';
        Corpus::factory()->create(['word' => $word]);
        $filteredWord = new FilteredWord($word);
        $collection = new FilteredWordCollection();
        $collection->addFilteredWord($filteredWord);
        $collection->storeNewFilteredWordsDefinitions(new MockDefinitionsApi());
        $this->assertDatabaseEmpty('definitions');

    }

    public function test_remove_filtered_word_that_no_definition_available()
    {
        $filteredWordOne = new FilteredWord('Hello');
        $filteredWordTwo = new FilteredWord('NO_DEFINITION_AVAILABLE');
        $collection = new FilteredWordCollection();
        $collection->addFilteredWord($filteredWordOne);
        $collection->addFilteredWord($filteredWordTwo);
        $collection->storeNewFilteredWordsDefinitions(new MockDefinitionsApi());
        $this->assertEqualsCanonicalizing([$filteredWordOne], $collection->toArray());

    }
}
