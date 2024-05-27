<?php

declare(strict_types=1);

namespace Feature;

use App\Apis\WordsFilterApi\PhpBasedWordFilterApi;
use App\DataObjects\FilteredWords\FilteredWord;
use App\DataObjects\FilteredWords\FilteredWordCollection;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PhpBasedWordFilterApiTest extends TestCase
{
    public static function sampleSentences(): array
    {
        return [[
            'aa bb cc',
            new FilteredWordCollection(
                new FilteredWord('aa'),
                new FilteredWord('bb'),
                new FilteredWord('cc'),
            ),
        ], [
            'aa   act  bb   aa',
            new FilteredWordCollection(
                new FilteredWord('aa'),
                new FilteredWord('bb'),
            ),
        ], [
            '+aa   aa-  bb.',
            new FilteredWordCollection(
                new FilteredWord('aa'),
                new FilteredWord('bb'),
            ),
        ], [
            'aa 1234 bb.',
            new FilteredWordCollection(
                new FilteredWord('aa'),
                new FilteredWord('bb'),
            ),
        ], [
            'followed bb ccccc',
            new FilteredWordCollection(
                new FilteredWord('bb'),
                new FilteredWord('ccccc'),
            ),
        ], [
            'a abc',
            new FilteredWordCollection(
                new FilteredWord('abc'),
            ),
        ],
        ];
    }

    #[DataProvider('sampleSentences')]
    public function test_filter_method(string $sentence, FilteredWordCollection $filteredWordCollection): void
    {
        $this->assertEquals($filteredWordCollection, (new PhpBasedWordFilterApi())->filter($sentence));

    }
}
