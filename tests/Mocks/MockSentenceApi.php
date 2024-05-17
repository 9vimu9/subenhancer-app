<?php

declare(strict_types=1);

namespace Tests\Mocks;

use App\Core\Contracts\Apis\SentencesApiInterface;
use App\DataObjects\Sentences\Sentence;
use App\DataObjects\Sentences\SentenceCollection;

class MockSentenceApi implements SentencesApiInterface
{
    public const string CAPTION_ONE = 'one';

    public const string CAPTION_TWO = 'two';

    public function getSentences(string $caption): SentenceCollection
    {
        return new SentenceCollection(
            new Sentence(self::CAPTION_ONE),
            new Sentence(self::CAPTION_TWO),
        );
    }
}
