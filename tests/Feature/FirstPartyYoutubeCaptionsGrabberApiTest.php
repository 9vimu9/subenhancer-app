<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Exceptions\InvalidYoutubeCaptionsFormatException;
use App\Exceptions\YoutubeVideoCaptionsCannotBeFoundException;
use App\Exceptions\YoutubeVideoCaptionsFetchException;
use App\Services\YoutubeCaptionsGrabberApi\FirstPartyYoutubeCaptionsGrabberApi;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class FirstPartyYoutubeCaptionsGrabberApiTest extends TestCase
{
    public static function provideInputs(): array
    {
        return [[
            [
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
            ],
        ]];
    }

    #[DataProvider('provideInputs')]
    public function test_getCaptions_method(array $response): void
    {
        Http::fake([
            config('app.captions_endpoint').'?source=youtube&id=*' => Http::response($response, Response::HTTP_OK),

        ]);

        $this->assertSame(
            json_encode($response['transcript'], JSON_THROW_ON_ERROR),
            (new FirstPartyYoutubeCaptionsGrabberApi())->getCaptions('my_video_id')
        );

    }

    /**
     * @return string[][]
     */
    public static function provideExceptions(): array
    {
        return [
            'exception is thrown when the youtube caption is not available' => [Response::HTTP_NOT_FOUND, YoutubeVideoCaptionsCannotBeFoundException::class, []],
            'exception is thrown when there is a server error' => [Response::HTTP_INTERNAL_SERVER_ERROR, YoutubeVideoCaptionsFetchException::class, []],
            'exception is thrown when the response format is incorrect' => [Response::HTTP_OK, InvalidYoutubeCaptionsFormatException::class, []],
        ];
    }

    #[DataProvider('provideExceptions')]
    public function test_proper_exceptions_are_thrown($statusCode, string $exceptionClass, array $response): void
    {
        Http::fake([
            config('app.captions_endpoint').'?source=youtube&id=*' => Http::response($response, $statusCode),

        ]);
        $this->expectException($exceptionClass);
        (new FirstPartyYoutubeCaptionsGrabberApi())->getCaptions('my_video_id');
    }
}
