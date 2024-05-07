<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Exceptions\DurationHasnotBeenSavedBeforeSaveCaptionInSentencesException;
use App\Models\Source;
use App\Services\Captions\Caption;
use App\Services\SentencesApi\SentencesApiInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CaptionTest extends TestCase
{
    use RefreshDatabase;

    public function test_save_duration(): void
    {
        $source = Source::factory()->create();
        $caption = new Caption();
        $caption->setStartTime(1);
        $caption->setEndTime(2);
        $caption->saveDuration($source->getAttribute('id'));
        $this->assertDatabaseHas('durations', [
            'start_time_in_millis' => 1,
            'end_time_in_millis' => 2,
        ]);

    }

    public function test_exception_is_thrown_when_trying_to_save_sentences_without_saving_duration(): void
    {
        $caption = new Caption();
        $this->expectException(DurationHasnotBeenSavedBeforeSaveCaptionInSentencesException::class);
        $caption->saveCaptionInSentences(new MockSentenceApi());
    }

    public function test_saveCaptionInSentences(): void
    {
        $source = Source::factory()->create();
        $caption = new Caption();
        $caption->setCaption('RANDOM_TEXT');
        $caption->setStartTime(1);
        $caption->setEndTime(2);
        $caption->saveDuration($source->getAttribute('id'));
        $sentences = $caption->saveCaptionInSentences(new MockSentenceApi());
        $this->assertEquals('sentence_1', $sentences[0]->getAttribute('sentence'));
        $this->assertEquals('sentence_2', $sentences[1]->getAttribute('sentence'));
    }

    public function test_hasFilteredWordInCaption()
    {
        $filteredWords = ['random'];
        $caption = new Caption();

        $caption->setCaption('RANDOM TEXT');
        $actual = $caption->hasFilteredWordInCaption($filteredWords);
        $this->assertTrue($actual);

        $caption->setCaption('UNRANDOM TEXT');
        $actual = $caption->hasFilteredWordInCaption($filteredWords);
        $this->assertFalse($actual);
    }
}

class MockSentenceApi implements SentencesApiInterface
{
    public function getSentences(string $caption): array
    {
        return ['sentence_1', 'sentence_2'];
    }
}
