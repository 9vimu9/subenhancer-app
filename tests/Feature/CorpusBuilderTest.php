<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Exceptions\WordInCorpusException;
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

    public function test_saveWord_throws_exception_when_word_does_exist(): void
    {
        $savedWord = 'word';
        Corpus::factory()->create(['word' => $savedWord]);
        $this->expectException(WordInCorpusException::class);
        Corpus::query()->saveWord($savedWord);
    }

    #[DataProvider('wordVariations')]
    public function test_findByWord(string $word): void
    {
        $expected = Corpus::factory()->create(['word' => strtolower($word)]);
        $actual = Corpus::query()->findByWord($word, ['word']);
        $this->assertSame($expected->word, $actual->word);

    }

    #[DataProvider('wordVariations')]
    public function test_save_word(string $word): void
    {
        Corpus::query()->saveWord($word);
        $this->assertDatabaseHas('corpuses', ['word' => strtolower($word)]);

    }

    public static function wordVariations(): array
    {
        return [
            'uppercase word' => ['RANDOM_WORD_1'],
            'lowercase word' => ['random_word_2'],
            'mixcase word' => ['ranDom_Word_3']];
    }
}
