<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Exceptions\IncorrectYoutubeVideoLinkProvidedException;
use App\Models\Youtubevideo;
use App\Resources\YoutubeUrlResource;
use App\Traits\Testing\PhpUnitUtils;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class YoutubeUrlResourceTest extends TestCase
{
    use PhpUnitUtils, RefreshDatabase;

    public function test_returns_true_when_the_link_is_already_in_the_table(): void
    {
        $video = Youtubevideo::factory()->create();
        $videoUrl = 'http://youtu.be/'.$video->video_id;
        $videoResource = new YoutubeUrlResource($videoUrl);
        $this->assertTrue($videoResource->isAlreadyExist());
    }

    public function test_returns_false_when_the_link_is_new(): void
    {
        $videoUrl = 'http://youtu.be/0zM3nApSvMg';
        $videoResource = new YoutubeUrlResource($videoUrl);
        $this->assertFalse($videoResource->isAlreadyExist());
    }

    public function test_returns_video_id_get_video_id(): void
    {
        $urls = [
            'http://www.youtube.com/watch?v=0zM3nApSvMg&feature=feedrec_grec_index',
            'https://www.youtube.com/watch?v=0zM3nApSvMg&feature=feedrec_grec_index',
            'http://www.youtube.com/v/0zM3nApSvMg?fs=1&amp;hl=en_US&amp;rel=0',
            'http://www.youtube.com/watch?v=0zM3nApSvMg#t=0m10s',
            'http://www.youtube.com/embed/0zM3nApSvMg?rel=0',
            'http://www.youtube.com/watch?v=0zM3nApSvMg',
            'http://youtu.be/0zM3nApSvMg',
        ];

        foreach ($urls as $url) {
            $actualId = $this->callMethod((new YoutubeUrlResource($url)), 'getVideoId', [$url]);
            $this->assertEquals('0zM3nApSvMg', $actualId);
        }
    }

    public function test_throws_exception_when_the_link_is_invalid(): void
    {
        $urls = [
            'http://www.youtube.com/user/IngridMichaelsonVEVO#p/a/u/1/QdK8U-VIH_o',
            'http://www.youtubepi.com/watch?v=0zM3nApSvMg',
        ];

        foreach ($urls as $url) {
            $this->expectException(IncorrectYoutubeVideoLinkProvidedException::class);
            $this->callMethod((new YoutubeUrlResource($url)), 'getVideoId', [$url]);
        }
    }
}
