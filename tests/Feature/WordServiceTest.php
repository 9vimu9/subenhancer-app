<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Apis\WordsFilterApi\WordFilterApiInterface;
use App\DataObjects\Captions\Caption;
use App\DataObjects\Captions\CaptionsCollection;
use App\DataObjects\FilteredWords\FilteredWord;
use App\DataObjects\FilteredWords\FilteredWordCollection;
use App\Models\Corpus;
use App\Services\WordService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class WordServiceTest extends TestCase
{
    use RefreshDatabase;

    #[DataProvider('provideInputs')]
    public function test_store_words_by_collection(WordService $service, FilteredWordCollection $collection): void
    {
        $service->storeWordsByCollection($collection);
        $this->assertDatabaseHas('corpuses', ['word' => 'word 1']);
        $this->assertDatabaseHas('corpuses', ['word' => 'word 2']);
    }

    #[DataProvider('provideInputs')]
    public function test_ignore_existing_words(WordService $service, FilteredWordCollection $collection): void
    {
        Corpus::factory()->create(['word' => 'word 1']);
        $service->storeWordsByCollection($collection);
        $this->assertDatabaseHas('corpuses', ['word' => 'word 2']);
        $this->assertDatabaseCount('corpuses', 2);
    }

    public static function provideInputs(): array
    {
        $service = new WordService(new MockWordFilterApi());
        $collection = new FilteredWordCollection();
        $wordOne = new FilteredWord('word 1');
        $wordTwo = new FilteredWord('word 2');
        $collection->add($wordOne);
        $collection->add($wordTwo);

        return [[$service, $collection]];
    }

    #[DataProvider('provideInputs')]
    public function test_filter_words_by_collection(WordService $service, FilteredWordCollection $expectedFilteredWordCollection): void
    {
        $captionsCollection = new CaptionsCollection();
        $capOne = new Caption();
        $capOne->setCaption('random_string');
        $captionsCollection->add($capOne);
        $actualfilteredWordCollection = $service->filterWordsByCollection($captionsCollection);
        $this->assertEqualsCanonicalizing($actualfilteredWordCollection, $expectedFilteredWordCollection);

    }
}

class MockWordFilterApi implements WordFilterApiInterface
{
    public function filter(string $words): FilteredWordCollection
    {
        $collection = new FilteredWordCollection();
        $wordOne = new FilteredWord('word 1');
        $wordTwo = new FilteredWord('word 2');
        $collection->add($wordOne);
        $collection->add($wordTwo);

        return $collection;
    }
}
