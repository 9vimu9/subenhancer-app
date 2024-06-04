<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Dtos\CorpusDto;
use App\Dtos\CorpusDtoCollection;
use App\Traits\StringArrayOperationsTrait;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class StringArrayOperationsTraitTest extends TestCase
{
    public static function sampleSentences(): array
    {
        $filteredWords = new CorpusDtoCollection(new CorpusDto(word: 'aa'), new CorpusDto(word: 'dd'));
        $expected = new CorpusDtoCollection(new CorpusDto(word: 'aa'));

        return [
            'Happy path' => ['aa bb cc', $filteredWords, $expected],
            'With perenthis' => ['aa<bb cc', $filteredWords, $expected],
            'With Upper case letters' => ['aa<bb cc', $filteredWords, $expected],
            'With special chars' => ['++++aA<&&&bb cc', $filteredWords, $expected],
        ];
    }

    #[DataProvider('sampleSentences')]
    public function test_getIncludedFilteredWordsInTheSentence(string $sentence, CorpusDtoCollection $filteredWords, CorpusDtoCollection $expected): void
    {
        $objectWithTrait = new class
        {
            use StringArrayOperationsTrait;
        };
        $actual = $objectWithTrait->getIncludedFilteredWordsInTheSentence($sentence, $filteredWords);
        $this->assertEquals($expected, $actual);

    }
}
