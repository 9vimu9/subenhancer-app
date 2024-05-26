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
            'Happy path' => ['aa bb cc', ['aa', 'dd'], ['aa']],
            'With Parenthis' => ['aa<bb cc', ['aa', 'dd'], ['aa']],
            'With Upper case letters' => ['aA<bb cc', ['aa', 'dd'], ['aa']],
            'when array has upper case item' => ['aa bb cc', ['AA', 'dd'], ['aa']],
            'With special chars' => ['++++aA<&&&bb cc', ['aa', 'dd'], ['aa']],
        ];
    }

    #[DataProvider('sampleSentences')]
    public function test_getIncludedFilteredWordsInTheSentence(string $sentence, array $filteredWords, array $expected): void
    {
        $objectWithTrait = new class
        {
            use StringArrayOperationsTrait;
        };
        $this->assertEquals(
            $expected,
            $objectWithTrait->getIncludedFilteredWordsInTheSentence($sentence, $filteredWords));

    }
}
