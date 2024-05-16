<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Events\DurationSaved;
use App\Events\SentenceSaved;
use App\Listeners\SaveSentences;
use App\Services\Captions\Caption;
use App\Services\Sentences\Sentence;
use App\Services\Sentences\SentenceCollection;
use App\Services\SentenceService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Mockery\MockInterface;
use Tests\TestCase;

class SaveSentencesTest extends TestCase
{
    use RefreshDatabase;

    public function test_save_sentences(): void
    {
        $sentence = new Sentence();
        $sentence->setSentence('RANDOM SENTENCE');

        $sentenceCollection = new SentenceCollection();
        $sentenceCollection->add($sentence);
        $sentenceCollection->add($sentence);

        $sentenceModel = \App\Models\Sentence::factory()->create();
        $service = $this->partialMock(SentenceService::class, function (MockInterface $mock) use ($sentenceCollection, $sentenceModel) {
            $mock->shouldReceive('captionToSentences')->andReturn($sentenceCollection);
            $mock->shouldReceive('storeSentence')->andReturn($sentenceModel);
        });

        Event::fake();
        $listener = new SaveSentences($service);
        $listener->handle(new DurationSaved([], 1, new Caption()));
        Event::assertDispatchedTimes(SentenceSaved::class, iterator_count($sentenceCollection->getIterator()));
    }
}
