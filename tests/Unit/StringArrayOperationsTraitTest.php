<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Traits\StringArrayOperationsTrait;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class StringArrayOperationsTraitTest extends TestCase
{
    public static function sampleSentences(): array
    {
        return [
            'Happy path' => ['aa bb cc', [['word' => 'aa'], ['word' => 'dd']], [['word' => 'aa']]],
            'With Parenthis' => ['aa<bb cc', [['word' => 'aa'], ['word' => 'dd']], [['word' => 'aa']]],
            'With Upper case letters' => ['aA<bb cc', [['word' => 'aa'], ['word' => 'dd']], [['word' => 'aa']]],
            'when array has upper case item' => ['aa bb cc', [['word' => 'AA'], ['word' => 'dd']], [['word' => 'AA']]],
            'With special chars' => ['++++aA<&&&bb cc', [['word' => 'aa'], ['word' => 'dd']], [['word' => 'aa']]],
        ];
    }

    #[DataProvider('sampleSentences')]
    public function test_getIncludedFilteredWordsInTheSentence(string $sentence, array $filteredWords, array $expected): void
    {
        $objectWithTrait = new class
        {
            use StringArrayOperationsTrait;
        };
        $actual = $objectWithTrait->getIncludedFilteredWordsInTheSentence($sentence, $filteredWords);
        $this->assertEquals($expected, $actual);

    }
}
