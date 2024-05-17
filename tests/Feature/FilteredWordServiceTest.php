<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Corpus;
use App\Models\Sentence;
use App\Services\FilteredWordService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Tests\TestCase;

class FilteredWordServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_saveFilteredWordWhichFoundInSentence(): void
    {
        $sentenceModel = Sentence::factory()->create();
        $sentence = new \App\DataObjects\Sentences\Sentence();
        $sentence->setSentence('RANDOM_TEXT');

        $wordOne = 'word_one';
        $wordTwo = 'word_two';
        Corpus::factory()->create(['word' => $wordOne]);
        Corpus::factory()->create(['word' => $wordTwo]);
        $service = $this->partialMock(FilteredWordService::class, function (MockInterface $mock) use ($wordOne, $wordTwo) {
            $mock->shouldReceive('getintersectionofwordarrays')
                ->andReturn([$wordOne, $wordTwo]);
        });
        $service->saveFilteredWordWhichFoundInSentence([], $sentence, $sentenceModel->id);
        $this->assertDatabaseCount('captionwords', 2);

    }

    public function test_not_saving_the_word_when_it_is_not_in_corpus(): void
    {
        $sentenceModel = Sentence::factory()->create();
        $sentence = new \App\DataObjects\Sentences\Sentence();
        $sentence->setSentence('RANDOM_TEXT');

        $wordOne = 'word_one';
        $wordTwo = 'word_two';
        Corpus::factory()->create(['word' => $wordOne]);
        $service = $this->partialMock(FilteredWordService::class, function (MockInterface $mock) use ($wordOne, $wordTwo) {
            $mock->shouldReceive('getintersectionofwordarrays')
                ->andReturn([$wordOne, $wordTwo]);
        });
        $service->saveFilteredWordWhichFoundInSentence([], $sentence, $sentenceModel->id);
        $this->assertDatabaseCount('captionwords', 1);

    }
}
