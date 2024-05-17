<?php

declare(strict_types=1);

namespace Tests\Mocks;

use App\DataObjects\Sentences\Sentence;
use App\DataObjects\Sentences\SentenceCollection;
use App\Services\SentencesApi\SentencesApiInterface;

class MockSentenceApi implements SentencesApiInterface
{
    public const string CAPTION_ONE = 'one';

    public const string CAPTION_TWO = 'two';

    public function getSentences(string $caption): SentenceCollection
    {
        $sentences = new SentenceCollection();
        $sentenceOne = new Sentence();
        $sentenceOne->setSentence(self::CAPTION_ONE);
        $sentenceTwo = new Sentence();
        $sentenceTwo->setSentence(self::CAPTION_TWO);
        $sentences->add($sentenceOne);
        $sentences->add($sentenceTwo);

        return $sentences;
    }
}
