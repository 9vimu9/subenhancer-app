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
        Corpus::factory()->create(['word' => 'word']);
        $this->expectException(WordInCorpusException::class);
        Corpus::query()->saveWord('word');
    }

    #[DataProvider('wordVariations')]
    public function test_findByWord(string $word): void
    {
        $expected = Corpus::factory()->create(['word' => strtolower($word)]);
        $actual = Corpus::query()->findByWord($word);
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
            'word with all upper case' => ['RANDOM_WORD_1'],
            'word with all small case' => ['random_word_2'],
            'word with mix case' => ['ranDom_Word_3']];
    }
}
