<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Core\Contracts\Apis\YoutubeCaptionsGrabberApiInterface;
use App\Exceptions\InvalidYoutubeCaptionException;
use App\Resources\YoutubeUrlResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Mocks\MockResourceModel;
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
        $captions = iterator_to_array($captionsCollection);

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

    public static function inputCaptions(): array
    {
        return [
            'new line character' => ['abc\ndef.', 'abc def.'],
            'alert character' => ['abc\adef.', 'abc def.'],
            'tab character' => ['abc\tdef.', 'abc def.'],
            'carriage return character' => ['abc\rdef.', 'abc def.'],
            'backscape character' => ['abc\bdef.', 'abc def.'],
            'extra spaces' => ['a  b  c       def.', 'a b c def.'],

        ];
    }

    #[DataProvider('inputCaptions')]
    public function test_sanitize(string $input, string $expected): void
    {
        $actual = (new YoutubeUrlResource(
            'http://youtu.be/0zM3nApSvMg',
            new MockResourceModel(), new MockValidYoutubeCaptionsGrabberApi())
        )->sanitize($input);
        $this->assertEquals($expected, $actual);
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
