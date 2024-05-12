<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Exceptions\InvalidYoutubeCaptionException;
use App\Models\ResourceModels\ResourceModelInterface;
use App\Models\Source;
use App\Resources\YoutubeUrlResource;
use App\Services\YoutubeCaptionsGrabberApi\YoutubeCaptionsGrabberApiInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class YoutubeUrlResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_toCaptions_method(): void
    {
        $captionsCollection = (new YoutubeUrlResource(
            'http://youtu.be/0zM3nApSvMg',
            new MockResourceModel(),
            new MockValidYoutubeCaptionsGrabberApi())
        )->toCaptions();
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
        $this->expectException(InvalidYoutubeCaptionException::class);
        (new YoutubeUrlResource(
            'http://youtu.be/0zM3nApSvMg',
            new MockResourceModel(),
            new MockInvalidYoutubeCaptionsGrabberApi())
        )->toCaptions();
    }
}

class MockResourceModel implements ResourceModelInterface
{
    public function resourceExists(): bool
    {
        return true;
    }

    public function saveToSource(?Model $resourceModel = null): Source
    {
        return new class extends Source
        {
        };
    }

    public function save(): Model
    {
        return new class extends Model
        {
        };
    }
}

class MockValidYoutubeCaptionsGrabberApi implements YoutubeCaptionsGrabberApiInterface
{
    public function getCaptions(string $videoId): string
    {
        return '[{"text":"[Applause]","start":300,"end":2400},{"text":"thank you very much very kind you lovely","start":800,"end":3900}]';
    }
}

class MockInvalidYoutubeCaptionsGrabberApi implements YoutubeCaptionsGrabberApiInterface
{
    public function getCaptions(string $videoId): string
    {
        return '[{"text":"[Applause]","start":300,"ends":2400}]';
    }
}
