<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Core\Contracts\Apis\WordFilterApiInterface;
use App\DataObjects\FilteredWords\FilteredWord;
use App\DataObjects\FilteredWords\FilteredWordCollection;
use App\Services\WordService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WordServiceTest extends TestCase
{
    use RefreshDatabase;

    public static function provideInputs(): array
    {
        $service = new WordService(new MockWordFilterApi());
        $collection = new FilteredWordCollection(
            new FilteredWord('word 1'),
            new FilteredWord('word 2'),
        );

        return [[$service, $collection]];
    }
}

class MockWordFilterApi implements WordFilterApiInterface
{
    public function filter(string $words): FilteredWordCollection
    {
        return new FilteredWordCollection(
            new FilteredWord('word 1'),
            new FilteredWord('word 2'),
        );
    }
}
