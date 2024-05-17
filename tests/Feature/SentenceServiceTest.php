<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\DataObjects\Captions\Caption;
use App\DataObjects\Sentences\Sentence;
use App\DataObjects\Sentences\SentenceCollection;
use App\Models\Duration;
use App\Services\SentenceService;
use Tests\Mocks\MockSentenceApi;
use Tests\TestCase;

class SentenceServiceTest extends TestCase
{
    public function test_caption_to_sentences(): void
    {
        $expected = new SentenceCollection();
        $sentenceOne = new Sentence();
        $sentenceOne->setSentence(MockSentenceApi::CAPTION_ONE);
        $sentenceTwo = new Sentence();
        $sentenceTwo->setSentence(MockSentenceApi::CAPTION_TWO);
        $expected->add($sentenceOne);
        $expected->add($sentenceTwo);

        $service = new SentenceService(new MockSentenceApi());
        $caption = new Caption();
        $caption->setCaption('RANDOM CAPTION');
        $actual = $service->captionToSentences($caption);
        $this->assertEquals($expected, $actual);

    }

    public function test_store_sentence(): void
    {
        $duration = Duration::factory()->create();
        $sentence = new Sentence();
        $sentence->setSentence(MockSentenceApi::CAPTION_ONE);
        $sentence->setOrder(1);

        $service = new SentenceService(new MockSentenceApi());
        $service->storeSentence($duration->id, $sentence);
        $this->assertDatabaseHas('sentences', ['duration_id' => $duration->id, 'sentence' => MockSentenceApi::CAPTION_ONE]);

    }
}
