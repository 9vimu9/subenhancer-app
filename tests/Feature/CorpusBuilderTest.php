<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Exceptions\WordInCorpusException;
use App\Exceptions\WordNotInCorpusException;
use App\Models\Corpus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CorpusBuilderTest extends TestCase
{
    use RefreshDatabase;

    public function test_findByWordOrFail_thrws_exception_when_word_does_not_exist(): void
    {
        $this->expectException(WordNotInCorpusException::class);
        Corpus::query()->findByWordOrFail('word');
    }

    public function test_saveWord_throws_exception_when_word_does_exist(): void
    {
        Corpus::factory()->create(['word' => 'word']);
        $this->expectException(WordInCorpusException::class);
        Corpus::query()->saveWord('word');
    }
}
