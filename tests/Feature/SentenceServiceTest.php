<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Services\Captions\Caption;
use App\Services\Sentences\Sentence;
use App\Services\Sentences\SentenceCollection;
use App\Services\SentenceService;
use Tests\TestCase;

class SentenceServiceTest extends TestCase
{
    public function test_caption_to_sentences(): void
    {
        $expected = new SentenceCollection();
        $sentenceOne = new Sentence();
        $sentenceOne->setSentence(\Tests\Mocks\MockSentenceApi::CAPTION_ONE);
        $sentenceTwo = new Sentence();
        $sentenceTwo->setSentence(\Tests\Mocks\MockSentenceApi::CAPTION_TWO);
        $expected->add($sentenceOne);
        $expected->add($sentenceTwo);

        $service = new SentenceService(new \Tests\Mocks\MockSentenceApi());
        $caption = new Caption();
        $caption->setCaption('RANDOM CAPTION');
        $actual = $service->captionToSentences($caption);
        $this->assertEquals($expected, $actual);

    }
}
