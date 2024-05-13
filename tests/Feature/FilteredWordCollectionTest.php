<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Services\FilteredWords\FilteredWord;
use App\Services\FilteredWords\FilteredWordCollection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class FilteredWordCollectionTest extends TestCase
{
    use RefreshDatabase;

    #[DataProvider('provideInputs')]
    public function test_to_array_method(
        FilteredWordCollection $filteredWordCollection,
        FilteredWord $filteredWordOne,
        FilteredWord $filteredWordTwo,
    ): void {
        $this->assertEqualsCanonicalizing([$filteredWordOne, $filteredWordTwo], $filteredWordCollection->toArray());
    }

    #[DataProvider('provideInputs')]
    public function test_to_array_of_words(
        FilteredWordCollection $filteredWordCollection,
        FilteredWord $filteredWordOne,
        FilteredWord $filteredWordTwo,
    ): void {
        $this->assertEquals(
            [$filteredWordOne->getWord(), $filteredWordTwo->getWord()],
            $filteredWordCollection->toArrayOfWords()
        );

    }

    public static function provideInputs(): array
    {
        $filteredWordOne = new FilteredWord('filtered word 1');
        $filteredWordTwo = new FilteredWord('filtered word 2');
        $filteredWordCollection = new FilteredWordCollection();
        $filteredWordCollection->addFilteredWord($filteredWordOne);
        $filteredWordCollection->addFilteredWord($filteredWordTwo);

        return [[$filteredWordCollection, $filteredWordOne, $filteredWordTwo]];
    }
}
