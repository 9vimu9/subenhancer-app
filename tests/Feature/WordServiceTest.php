<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Services\FilteredWords\FilteredWord;
use App\Services\FilteredWords\FilteredWordCollection;
use App\Services\WordService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WordServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_words_by_collection(): void
    {
        $service = new WordService();
        $collection = new FilteredWordCollection();
        $wordOne = new FilteredWord('word 1');
        $wordTwo = new FilteredWord('word 2');
        $collection->addFilteredWord($wordOne);
        $collection->addFilteredWord($wordTwo);
        $service->storeWordsByCollection($collection);
        $this->assertDatabaseHas('corpuses', ['word' => 'word 1']);
        $this->assertDatabaseHas('corpuses', ['word' => 'word 2']);
    }
}
