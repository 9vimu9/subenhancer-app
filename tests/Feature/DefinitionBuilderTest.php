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
        $definitions = Definition::factory()->count(3)->create(['corpus_id' => $corpus->id]);
        $expected = $definitions->pluck('definition')->toArray();
        $actual = Definition::query()->getCandidateDefinitionsArrayByWord($corpus->id);
        $this->assertEquals($expected, $actual);

    }
}
