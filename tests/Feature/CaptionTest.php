<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Exceptions\DurationHasnotBeenSavedBeforeSaveCaptionInSentencesException;
use App\Models\Source;
use App\Services\Captions\Caption;
use App\Services\Sentences\Sentence;
use App\Services\Sentences\SentenceCollection;
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
        $caption->saveSentencesInTheCaption(new MockSentenceApi());
    }

    public function test_saveSentencesInTheCaption(): void
    {
        $source = Source::factory()->create();
        $caption = new Caption();
        $caption->setCaption('RANDOM_TEXT');
        $caption->setStartTime(1);
        $caption->setEndTime(2);
        $caption->saveDuration($source->getAttribute('id'));
        $sentences = $caption->saveSentencesInTheCaption(new MockSentenceApi());
        $this->assertDatabaseHas('sentences', ['sentence' => 'sentence_1']);
        $this->assertDatabaseHas('sentences', ['sentence' => 'sentence_2']);
    }

    public function test_hasFilteredWordInCaption(): void
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
    public function getSentences(string $caption): SentenceCollection
    {
        $collection = new SentenceCollection();
        $sentenceOne = new Sentence();
        $sentenceOne->setSentence('sentence_1');
        $sentenceOne->setOrder(0);

        $sentenceTwo = new Sentence();
        $sentenceTwo->setSentence('sentence_2');
        $sentenceTwo->setOrder(1);

        $collection->add($sentenceOne);
        $collection->add($sentenceTwo);

        return $collection;
    }
}
