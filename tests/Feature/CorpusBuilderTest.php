<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\DataObjects\FilteredWords\FilteredWord;
use App\DataObjects\FilteredWords\FilteredWordCollection;
use App\Exceptions\WordNotInCorpusException;
use App\Models\Corpus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class CorpusBuilderTest extends TestCase
{
    use RefreshDatabase;

    public function test_findByWordOrFail_thrws_exception_when_word_does_not_exist(): void
    {
        $this->expectException(WordNotInCorpusException::class);
        Corpus::query()->findByWordOrFail('word');
    }

    #[DataProvider('wordVariations')]
    public function test_findByWord(string $word): void
    {
        $expected = Corpus::factory()->create(['word' => strtolower($word)]);
        $actual = Corpus::query()->findByWord($word, ['word']);
        $this->assertSame($expected->word, $actual->word);

    }

    public static function wordVariations(): array
    {
        return [
            'uppercase word' => ['RANDOM_WORD_1'],
            'lowercase word' => ['random_word_2'],
            'mixcase word' => ['ranDom_Word_3']];
    }

    public function test_storeByCollection(): void
    {

        $collection = new FilteredWordCollection(
            new FilteredWord('aa'),
            new FilteredWord('bb'),
            new FilteredWord('cc'),
        );
        Corpus::query()->storeByCollection($collection);
        $this->assertDatabaseHas('corpuses', ['word' => 'aa']);
        $this->assertDatabaseHas('corpuses', ['word' => 'bb']);
        $this->assertDatabaseHas('corpuses', ['word' => 'cc']);
    }
}
