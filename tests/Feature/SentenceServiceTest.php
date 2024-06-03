<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\DataObjects\Captions\Caption;
use App\DataObjects\Sentences\Sentence;
use App\DataObjects\Sentences\SentenceCollection;
use App\Services\SentenceService;
use Tests\Mocks\MockSentenceApi;
use Tests\TestCase;

class SentenceServiceTest extends TestCase
{
    public function test_caption_to_sentences(): void
    {
        $sentenceOne = new Sentence(
            sentence: MockSentenceApi::CAPTION_ONE
        );
        $sentenceTwo = new Sentence(
            sentence: MockSentenceApi::CAPTION_TWO
        );
        $expected = new SentenceCollection($sentenceOne, $sentenceTwo);

        $service = new SentenceService(new MockSentenceApi());
        $caption = new Caption(captionString: 'RANDOM CAPTION', startTime: 0, endTime: 0);
        $actual = $service->captionToSentences($caption);
        $this->assertEquals($expected, $actual);

    }
}
