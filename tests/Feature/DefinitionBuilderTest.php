<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Corpus;
use App\Models\Definition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DefinitionBuilderTest extends TestCase
{
    use RefreshDatabase;

    public function test_getCandidateDefinitionsArrayByWord(): void
    {
        $corpus = Corpus::factory()->create();
        Definition::factory()->create(['definition' => 'RANDOM_1', 'corpus_id' => $corpus->id]);
        Definition::factory()->create(['definition' => 'RANDOM_2', 'corpus_id' => $corpus->id]);
        $expected = [1 => 'RANDOM_1', 2 => 'RANDOM_2'];
        $actual = Definition::query()->getCandidateDefinitionsArrayByWordOrFail($corpus->id);
        $this->assertEquals($expected, $actual);

    }
}
