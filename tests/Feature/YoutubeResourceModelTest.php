<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\ResourceModels\YoutubeResourceModel;
use App\Models\Youtubevideo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class YoutubeResourceModelTest extends TestCase
{
    use RefreshDatabase;

    const string YOUTUBE_URL = 'https://www.youtube.com/watch?v=';

    public function test_returns_true_when_the_link_is_already_in_the_table(): void
    {
        $video = Youtubevideo::factory()->create();
        $this->assertTrue(
            (new YoutubeResourceModel(self::YOUTUBE_URL.$video->video_id)
            )->resourceExists());
    }

    public function test_returns_false_when_the_link_is_new(): void
    {
        $this->assertFalse(
            (new YoutubeResourceModel(self::YOUTUBE_URL.'my_video_id')
            )->resourceExists());
    }

    public function test_insert_a_record_to_sources_table_when_a_record_is_saved_to_youtubevideo_table(): void
    {
        $videoId = 'my_video_id';
        (new YoutubeResourceModel(self::YOUTUBE_URL.$videoId))->saveToSource();
        $this->assertDatabaseHas('youtubevideos', ['video_id' => $videoId]);
        $this->assertDatabaseHas('sources', ['sourceable_type' => Youtubevideo::class, 'sourceable_id' => 1]);

    }
}
