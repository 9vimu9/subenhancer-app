<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Captionword;
use App\Models\Duration;
use App\Models\Sentence;
use App\Models\Source;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilteredwordBuilderTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_words_by_source_id(): void
    {
        $source = Source::factory()->create();
        $source->each(function (Source $source) {
            $source->durations()
                ->saveMany(
                    Duration::factory()
                        ->count(20)
                        ->create(['source_id' => $source])
                        ->each(function (Duration $duration) {
                            $duration->sentences()
                                ->saveMany(
                                    Sentence::factory()
                                        ->count(2)
                                        ->create(['duration_id' => $duration->id])
                                        ->each(function (Sentence $sentence) {
                                            $sentence
                                                ->filteredwords()
                                                ->saveMany(
                                                    Captionword::factory()
                                                        ->count(1)
                                                        ->create([
                                                            'sentence_id' => $sentence->id,
                                                        ])
                                                );
                                        })
                                );

                        })
                );
        });
        $this->assertEqualsCanonicalizing(
            Captionword::all(),
            Captionword::query()->getWordsBySourceId($source->id));

    }
}
