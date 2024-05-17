<?php

declare(strict_types=1);

namespace Tests\Mocks;

use App\Apis\SentencesApi\SentencesApiInterface;
use App\DataObjects\Sentences\Sentence;
use App\DataObjects\Sentences\SentenceCollection;

class MockSentenceApi implements SentencesApiInterface
{
    public const string CAPTION_ONE = 'one';

    public const string CAPTION_TWO = 'two';

    public function getSentences(string $caption): SentenceCollection
    {
        $sentenceOne = new Sentence();
        $sentenceOne->setSentence(self::CAPTION_ONE);
        $sentenceTwo = new Sentence();
        $sentenceTwo->setSentence(self::CAPTION_TWO);

        return new SentenceCollection($sentenceOne, $sentenceTwo);
    }
}
