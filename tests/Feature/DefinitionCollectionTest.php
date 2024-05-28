<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\DataObjects\Definitions\DefinitionCollection;
use App\Models\Corpus;
use App\Models\Definition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DefinitionCollectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_loadByWord(): void
    {
        $corpus = Corpus::factory()->create();
        Definition::factory()->count(4)->create(['corpus_id' => $corpus->id]);
        $collection = new DefinitionCollection();
        $this->assertTrue($collection->loadByWord($corpus->word));
        $this->assertEquals(4, $collection->count());
    }
}
