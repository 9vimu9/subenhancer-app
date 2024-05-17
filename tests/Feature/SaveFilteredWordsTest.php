<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Events\SentenceSaved;
use App\Listeners\SaveFilteredWords;
use App\Models\Sentence;
use App\Services\FilteredWordServiceInterface;
use Tests\TestCase;

class SaveFilteredWordsTest extends TestCase
{
    public function test_listener_save_filtered_words(): void
    {
        $event = new SentenceSaved(
            ['sample'],
            new \App\DataObjects\Sentences\Sentence('sample sentence'),
            Sentence::factory()->create()->id
        );
        $expected = (new SaveFilteredWords(new MockFilteredWordService()))->handle($event);
        $this->assertNull($expected);
    }
}

class MockFilteredWordService implements FilteredWordServiceInterface
{
    public function saveFilteredWordWhichFoundInSentence(array $filteredWordArray, \App\DataObjects\Sentences\Sentence $sentence, int $sentenceId): void
    {
    }
}
