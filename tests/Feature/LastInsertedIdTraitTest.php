<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Core\Database\LastInsertedIdTrait;
use App\Models\Corpus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LastInsertedIdTraitTest extends TestCase
{
    use RefreshDatabase;

    public function test_getLastInsertedId(): void
    {

        $objectWithTrait = new class
        {
            use LastInsertedIdTrait;
        };
        $corpus = Corpus::factory()->create();
        $actual = (new class
        {
            use LastInsertedIdTrait;
        })->getLastInsertedId($corpus->getTable());
        $this->assertEquals(1, $actual);

    }

    public function test_throws_exception_when_table_is_invalid(): void
    {

        $this->expectException(\InvalidArgumentException::class);
        (new class
        {
            use LastInsertedIdTrait;
        })->getLastInsertedId('INVVALID_TABLE');

    }
}
