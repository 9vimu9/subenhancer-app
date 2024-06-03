<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Core\Contracts\Apis\WordFilterApiInterface;
use App\DataObjects\Captions\Caption;
use App\DataObjects\Captions\CaptionsCollection;
use App\DataObjects\FilteredWords\FilteredWord;
use App\DataObjects\FilteredWords\FilteredWordCollection;
use App\Services\WordService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WordServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_processWordsByCollection(): void
    {
        $collection = new CaptionsCollection(
            new Caption('word_1 word_2', 100, 200),
            new Caption('word_3 word_2', 200, 400),
        );
        $actual = (new WordService(new MockWordFilterApiInterface()))->processWordsByCollection($collection);
        $expected = new FilteredWordCollection(
            new FilteredWord('word_1'),
            new FilteredWord('word_2'),
        );
        $this->assertDatabaseHas('corpuses', ['word' => 'word_1']);
        $this->assertDatabaseHas('corpuses', ['word' => 'word_2']);
        $this->assertEquals($expected, $actual);

    }
}

class MockWordFilterApiInterface implements WordFilterApiInterface
{
    public function filter(string $words): FilteredWordCollection
    {
        return new FilteredWordCollection(
            new FilteredWord('word_1'),
            new FilteredWord('word_2'),
        );
    }
}
