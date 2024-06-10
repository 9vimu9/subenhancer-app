<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Core\Contracts\Dtos\AbstractDtoCollection;
use App\Core\Contracts\Dtos\Arrayable;
use App\Dtos\CorpusDto;
use App\Dtos\DefinitionDtoCollection;
use App\Dtos\DtoCollection;
use App\Models\Corpus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AbstractDtoCollectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_loadFromEloquentCollection_method(): void
    {
        $publicDtoCollection = new class extends AbstractDtoCollection
        {
        };
        $corpus = Corpus::factory()->count(1)->create();
        $expected = new DtoCollection(new CorpusDto($corpus[0]->id, $corpus[0]->word, new DefinitionDtoCollection()));
        $actual = $publicDtoCollection->loadFromEloquentCollection($corpus);
        $this->assertContainsOnlyInstancesOf(CorpusDto::class, $actual->items());
        $this->assertSameSize($expected->items(), $actual->items());
        $this->assertEquals($expected->items(), $actual->items());
    }

    public function test_toArray_method(): void
    {
        $dto = new MockDto(30);
        $publicDtoCollection = new class($dto) extends AbstractDtoCollection
        {
        };
        $expected = [['id' => 30]];
        $actual = $publicDtoCollection->toArray();
        $this->assertEquals($expected, $actual);
    }
}

readonly class MockDto implements Arrayable
{
    public function __construct(
        public int $id
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
        ];
    }
}
