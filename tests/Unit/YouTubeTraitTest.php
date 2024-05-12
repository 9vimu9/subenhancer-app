<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Exceptions\IncorrectYoutubeVideoLinkProvidedException;
use App\Traits\YoutubeTrait;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class YouTubeTraitTest extends TestCase
{
    use YouTubeTrait;

    public static function correctVideoLinkProvider(): array
    {
        return [
            ['http://www.youtube.com/watch?v=0zM3nApSvMg&feature=feedrec_grec_index'],
            ['https://www.youtube.com/watch?v=0zM3nApSvMg&feature=feedrec_grec_index'],
            ['http://www.youtube.com/v/0zM3nApSvMg?fs=1&amp;hl=en_US&amp;rel=0'],
            ['http://www.youtube.com/watch?v=0zM3nApSvMg#t=0m10s'],
            ['http://www.youtube.com/embed/0zM3nApSvMg?rel=0'],
            ['http://www.youtube.com/watch?v=0zM3nApSvMg'],
            ['http://youtu.be/0zM3nApSvMg'],
        ];
    }

    #[DataProvider('correctVideoLinkProvider')]
    public function test_returns_video_id_get_video_id(string $videoUrl): void
    {
        $actualId = $this->getVideoId($videoUrl);
        $this->assertEquals('0zM3nApSvMg', $actualId);
    }

    public static function incorrectVideoLinkProvider(): array
    {
        return [
            ['http://www.youtube.com/user/IngridMichaelsonVEVO#p/a/u/1/QdK8U-VIH_o'],
            //            ['http://www.youtubepi.com/watch?v=0zM3nApSvMg'],
        ];

    }

    #[DataProvider('incorrectVideoLinkProvider')]
    public function test_throws_exception_when_the_link_is_invalid(string $url): void
    {
        $this->expectException(IncorrectYoutubeVideoLinkProvidedException::class);
        $this->getVideoId($url);
    }
}
