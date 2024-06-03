<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\DataObjects\FilteredWords\FilteredWord;
use App\DataObjects\FilteredWords\FilteredWordCollection;
use App\Models\Corpus;
use App\Models\Definition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CorpusBuilderTest extends TestCase
{
    use RefreshDatabase;

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

    public function test_wordsWithDefinitionsByFilteredWordCollection(): void
    {
        $wordWithDefinitions = 'word_with_definitions';
        $corpusWithDefinition = Corpus::factory()->create(['word' => strtolower($wordWithDefinitions)]);
        Definition::factory()->create(['corpus_id' => $corpusWithDefinition->id]);

        $wordWithoutDefinitions = 'word_without_definitions';
        $corpusWithoutDefinition = Corpus::factory()->create(['word' => strtolower($wordWithoutDefinitions)]);

        $collection = new FilteredWordCollection(
            new FilteredWord($wordWithoutDefinitions),
            new FilteredWord($wordWithDefinitions),
        );
        $actual = Corpus::query()->wordsWithDefinitionsByFilteredWordCollection($collection);
        $this->assertCount(1, $actual);
        $this->assertSame($corpusWithDefinition->id, $actual->first()->id);

    }

    public function test_wordsWithoutDefinitionsByFilteredWordCollection(): void
    {
        $wordWithDefinitions = 'word_with_definitions';
        $corpusWithDefinition = Corpus::factory()->create(['word' => strtolower($wordWithDefinitions)]);
        Definition::factory()->create(['corpus_id' => $corpusWithDefinition->id]);

        $wordWithoutDefinitions = 'word_without_definitions';
        $corpusWithoutDefinition = Corpus::factory()->create(['word' => strtolower($wordWithoutDefinitions)]);

        $collection = new FilteredWordCollection(
            new FilteredWord($wordWithoutDefinitions),
            new FilteredWord($wordWithDefinitions),
        );
        $actual = Corpus::query()->wordsWithoutDefinitionsByFilteredWordCollection($collection);
        $this->assertCount(1, $actual);
        $this->assertSame($corpusWithoutDefinition->id, $actual->first()->id);

    }
}
