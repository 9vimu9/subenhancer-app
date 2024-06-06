<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Dtos\DefinitionDto;
use App\Dtos\DefinitionDtoCollection;
use App\Models\Corpus;
use App\Models\Definition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DefinitionDtoCollectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_definitionsArray(): void
    {
        $actual = (new DefinitionDtoCollection(
            new DefinitionDto(id: 1, definition: 'some definition'),
            new DefinitionDto(id: 2, definition: 'another definition'),
        ))->definitionsArrray();
        $expected = ['some definition', 'another definition'];

        $this->assertEquals($expected, $actual);

    }

    public function test_findDefinitionDtoByDefinition_method(): void
    {
        $domeDefinition = new DefinitionDto(id: 1, definition: 'some definition');
        $anotherDefinition = new DefinitionDto(id: 1, definition: 'another definition');
        $actual = (new DefinitionDtoCollection($domeDefinition, $anotherDefinition))->findDefinitionDtoByDefinition('some definition');
        $this->assertEquals($domeDefinition, $actual);

    }

    public function test_throws_exception_when_invalid_definition_presented(): void
    {
        $domeDefinition = new DefinitionDto(id: 1, definition: 'some definition');
        $anotherDefinition = new DefinitionDto(id: 1, definition: 'another definition');
        $this->expectException(\InvalidArgumentException::class);
        (new DefinitionDtoCollection($domeDefinition, $anotherDefinition))->findDefinitionDtoByDefinition('no definition');

    }

    public function test_loadByDefinitions(): void
    {
        $definitionCount = 3;
        $definitionDtoCollection = new DefinitionDtoCollection();
        $definitions = Definition::factory()->count($definitionCount)->create();
        $definitionDtoCollection->load($definitions);

        $this->assertEquals($definitionCount, $definitionDtoCollection->count());
        foreach (range(0, $definitionCount - 1) as $i) {
            $this->assertEquals($definitions->get($i)->definition, $definitionDtoCollection->get($i)->definition);
        }

    }

    public function test_when_definition_columns_are_restricted_in_loadByDefinitions_method_input_collection(): void
    {
        $definitionCount = 3;
        $definitionDtoCollection = new DefinitionDtoCollection();
        $corpus = Corpus::factory()->create();
        $definitions = Definition::factory()->count($definitionCount)->create(['corpus_id' => $corpus->id]);
        $corpus = Corpus::with('definitions:definition,corpus_id')->find($corpus->id);

        $definitionDtoCollection->load($corpus->definitions);
        $this->assertEquals($definitionCount, $definitionDtoCollection->count());
        foreach (range(0, $definitionCount - 1) as $i) {
            $this->assertEquals($definitions->get($i)->definition, $definitionDtoCollection->get($i)->definition);
        }
    }
}
