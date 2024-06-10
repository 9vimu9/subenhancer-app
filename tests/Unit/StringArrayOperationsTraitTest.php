<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Core\Contracts\Dtos\AbstractDtoCollection;
use App\Dtos\CorpusDto;
use App\Dtos\DefinitionDtoCollection;
use App\Dtos\DtoCollection;
use App\Traits\StringArrayOperationsTrait;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class StringArrayOperationsTraitTest extends TestCase
{
    public static function sampleSentences(): array
    {
        $filteredWords = new DtoCollection(new CorpusDto(id: 1, word: 'aa', definitions: new DefinitionDtoCollection()), new CorpusDto(id: 1, word: 'dd', definitions: new DefinitionDtoCollection()));
        $expected = new DtoCollection(new CorpusDto(id: 1, word: 'aa', definitions: new DefinitionDtoCollection()));

        return [
            'Happy path' => ['aa bb cc', $filteredWords, $expected],
            'With perenthis' => ['aa<bb cc', $filteredWords, $expected],
            'With Upper case letters' => ['aa<bb cc', $filteredWords, $expected],
            'With special chars' => ['++++aA<&&&bb cc', $filteredWords, $expected],
        ];
    }

    #[DataProvider('sampleSentences')]
    public function test_getIncludedFilteredWordsInTheSentence(string $sentence, DtoCollection $filteredWords, AbstractDtoCollection $expected): void
    {
        $objectWithTrait = new class
        {
            use StringArrayOperationsTrait;
        };
        $actual = $objectWithTrait->getIncludedFilteredWordsInTheSentence($sentence, $filteredWords);
        $this->assertEquals($expected, $actual);

    }
}
