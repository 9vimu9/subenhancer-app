<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Duration;
use App\Models\Sentence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SentenceBuilderTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_by_sentence_method(): void
    {
        $duration = Duration::factory()->create();
        $order = 1;
        $sampleSentence = 'sample sentence';
        $sentence = new \App\DataObjects\Sentences\Sentence(
            $sampleSentence, $order
        );
        Sentence::query()->createBySentence($duration->id, $sentence);
        $this->assertDatabaseHas('sentences', ['sentence' => $sampleSentence, 'order' => $order]);

    }
}
