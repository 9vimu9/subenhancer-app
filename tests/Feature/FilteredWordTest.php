<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\WordClassEnum;
use App\Exceptions\DefinitionAlreadyExistException;
use App\Models\Corpus;
use App\Services\FilteredWords\FilteredWord;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Mocks\MockDefinitionsApi;
use Tests\TestCase;

class FilteredWordTest extends TestCase
{
    use RefreshDatabase;

    public function test_filtered_word_store_definitions(): void
    {
        $word = 'Hello';
        (new FilteredWord($word))->storeDefinitions(new MockDefinitionsApi());
        $this->assertDatabaseHas('corpuses', ['word' => $word]);
        $this->assertDatabaseHas('definitions', [
            'definition' => '"Hello!" or an equivalent greeting.',
            'word_class' => WordClassEnum::NOUN->name,
        ]);
    }

    public function test_exception_is_thrown_when_the_word_is_already_stored(): void
    {
        $word = 'HELLO';
        Corpus::factory()->create(['word' => $word]);
        $this->expectException(DefinitionAlreadyExistException::class);
        (new FilteredWord($word))->storeDefinitions(new MockDefinitionsApi());
    }
}
