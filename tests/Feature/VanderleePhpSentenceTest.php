<?php

declare(strict_types=1);

namespace Feature;

use App\Apis\SentencesApi\VanderleeePhpSentence;
use App\DataObjects\Sentences\Sentence;
use App\DataObjects\Sentences\SentenceCollection;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class VanderleePhpSentenceTest extends TestCase
{
    public static function sampleSentences(): array
    {
        return [
            [
                'Hello there! How are you doing today? I hope everything is fine.',
                new SentenceCollection(
                    new Sentence('Hello there!', 0),
                    new Sentence('How are you doing today?', 1),
                    new Sentence('I hope everything is fine.', 2),
                ),
            ],
        ];
    }

    #[DataProvider('sampleSentences')]
    public function test_get_sentences(string $text, SentenceCollection $collection): void
    {
        $sentences = (new VanderleeePhpSentence())->getSentences($text);
        $this->assertEqualsCanonicalizing($collection, $sentences);
    }
}
