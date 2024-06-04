<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Dtos\DefinitionDto;
use App\Dtos\DefinitionDtoCollection;
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
}
