<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Corpus;
use App\Services\Sentences\Sentence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SentenceTest extends TestCase
{
    use RefreshDatabase;

    public function test_saveFilteredWordsWhichFoundInSentenceToCaptionword(): void
    {
        Corpus::factory()->create(['word' => 'hello']);
        Corpus::factory()->create(['word' => 'world']);

        $sentenceModel = \App\Models\Sentence::factory()->create(['sentence' => 'Hello World']);
        $sentence = new Sentence();
        $sentence->setSentence('Hello World');
        $sentence->setSentenceModel($sentenceModel);
        $sentence->saveFilteredWordsWhichFoundInSentenceToCaptionword(['world']);
        $this->assertDatabaseHas('captionwords', ['sentence_id' => $sentenceModel->id]);

    }
}
