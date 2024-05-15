<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Events\DurationSaved;
use App\Models\Source;
use App\Services\Captions\Caption;
use App\Services\Captions\CaptionsCollection;
use App\Services\CaptionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class CaptionServiceTest extends TestCase
{
    use RefreshDatabase;

    const int CAPTION_ONE_START_TIME = 10;

    const int CAPTION_ONE_END_TIME = 20;

    const int CAPTION_TWO_START_TIME = 30;

    const int CAPTION_TWO_END_TIME = 40;

    public static function dataProvider(): array
    {
        $collection = new CaptionsCollection();
        $captionOne = new Caption();
        $captionOne->setStartTime(self::CAPTION_ONE_START_TIME);
        $captionOne->setEndTime(self::CAPTION_ONE_END_TIME);
        $captionOne->setCaption('sdsdsd');
        $collection->add($captionOne);

        $captionTwo = new Caption();
        $captionTwo->setStartTime(self::CAPTION_TWO_START_TIME);
        $captionTwo->setEndTime(self::CAPTION_TWO_END_TIME);
        $captionTwo->setCaption('sdsdsd');
        $collection->add($captionTwo);

        return [[$collection]];
    }

    #[DataProvider('dataProvider')]
    public function test_save_durations_by_collection(CaptionsCollection $collection): void
    {
        $source = Source::factory()->create();
        Event::fake();
        $service = $this->partialMock(CaptionService::class, function (MockInterface $mock) {
            $mock->shouldReceive('getintersectionofwordarrays')
                ->andReturn([1]);
        });
        $service->saveDurationsByCollection($collection, $source->id, []);

        Event::assertDispatched(DurationSaved::class, 2);

        $this->assertDatabaseHas('durations',
            [
                'source_id' => $source->id,
                'start_time_in_millis' => self::CAPTION_ONE_START_TIME,
                'end_time_in_millis' => self::CAPTION_ONE_END_TIME,
            ],

        );
        $this->assertDatabaseHas('durations',
            [
                'source_id' => $source->id,
                'start_time_in_millis' => self::CAPTION_TWO_START_TIME,
                'end_time_in_millis' => self::CAPTION_TWO_END_TIME,
            ]
        );

    }

    #[DataProvider('dataProvider')]
    public function test_no_duration_is_saved_when_caption_has_no_common_words_with_filtered_words(CaptionsCollection $collection): void
    {
        $source = Source::factory()->create();
        Event::fake();
        $service = $this->partialMock(CaptionService::class, function (MockInterface $mock) {
            $mock->shouldReceive('getintersectionofwordarrays')
                ->andReturn([]);
        });
        $service->saveDurationsByCollection($collection, $source->id, []);

        $this->assertDatabaseCount('durations', 0);

        Event::assertNotDispatched(DurationSaved::class);
    }
}
