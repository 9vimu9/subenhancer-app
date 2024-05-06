<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Exceptions\IncorrectYoutubeVideoLinkProvidedException;
use App\Exceptions\InvalidYoutubeCaptionException;
use App\Exceptions\YoutubeVideoCaptionsFetchException;
use App\Models\Youtubevideo;
use App\Resources\YoutubeUrlResource;
use App\Traits\Testing\PhpUnitUtils;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
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

        $this->expectException(IncorrectYoutubeVideoLinkProvidedException::class);
        foreach ($urls as $url) {
            $this->callMethod((new YoutubeUrlResource($url)), 'getVideoId');
        }
    }

    public function test_fetch_for_Youtube(): void
    {
        $response = [
            'transcript' => [
                [
                    'text' => '[Applause]',
                    'start' => 300,
                    'end' => 2400,
                ],
                [
                    'text' => 'thank you very much very kind you lovely',
                    'start' => 800,
                    'end' => 3900,
                ],
            ],
        ];

        $url = config('app.captions_endpoint').'?source=youtube&id=*';
        Http::fake([
            $url => Http::response($response, Response::HTTP_OK),

        ]);

        $videoUrl = 'http://youtu.be/0zM3nApSvMg';
        $videoResource = new YoutubeUrlResource($videoUrl);
        $this->assertSame(json_encode($response['transcript'], JSON_THROW_ON_ERROR), $videoResource->fetch());

    }

    public function test_throw_exception_when_the_captions_cannot_be_found(): void
    {
        $url = config('app.captions_endpoint').'?source=youtube&id=*';
        Http::fake([
            $url => Http::sequence()->pushStatus(Response::HTTP_NOT_FOUND),
        ]);
        $this->expectException(YoutubeVideoCaptionsFetchException::class);
        (new YoutubeUrlResource('http://youtu.be/0zM3nApSvMg'))->fetch();
    }

    public function test_throw_exception_when_the_captions_service_returns_internal_service_error(): void
    {
        $url = config('app.captions_endpoint').'?source=youtube&id=*';
        Http::fake([
            $url => Http::sequence()->pushStatus(Response::HTTP_INTERNAL_SERVER_ERROR),
        ]);
        $this->expectException(YoutubeVideoCaptionsFetchException::class);
        (new YoutubeUrlResource('http://youtu.be/0zM3nApSvMg'))->fetch();
    }

    public function test_toCaptions_method(): void
    {
        $captionString = '[{"text":"[Applause]","start":300,"end":2400},{"text":"thank you very much very kind you lovely","start":800,"end":3900}]';

        $captionsCollection = (new YoutubeUrlResource('http://youtu.be/0zM3nApSvMg'))->toCaptions($captionString);
        $captions = $captionsCollection->captions();

        $this->assertEquals('[Applause]', $captions[0]->getCaption());
        $this->assertEquals(300, $captions[0]->getStartTime());
        $this->assertEquals(2400, $captions[0]->getEndTime());

        $this->assertEquals('thank you very much very kind you lovely', $captions[1]->getCaption());
        $this->assertEquals(800, $captions[1]->getStartTime());
        $this->assertEquals(3900, $captions[1]->getEndTime());
    }

    public function test_throws_exception_when_incorrect_youtube_captions_are_provided(): void
    {
        $captionString = '[{"text":"[Applause]","start":300,"ends":2400}]';
        $this->expectException(InvalidYoutubeCaptionException::class);
        $captionsCollection = (new YoutubeUrlResource('http://youtu.be/0zM3nApSvMg'))->toCaptions($captionString);
        $captionsCollection->captions();
    }

    public function test_resource_can_be_recorded_to_youtubevideos_table(): void
    {
        $videoId = '0zM3nApSvMg';
        $resource = new YoutubeUrlResource('http://youtu.be/'.$videoId);
        $source = $resource->storeResourceTable();
        $this->assertDatabaseHas('youtubevideos', ['video_id' => $videoId]);
        $this->assertDatabaseHas('sources', ['sourceable_id' => 1, 'sourceable_type' => Youtubevideo::class]);
        $this->assertEquals(Youtubevideo::class, $source->getAttribute('sourceable_type'));
    }
}
