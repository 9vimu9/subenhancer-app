<?php

declare(strict_types=1);

namespace App\Apis\YoutubeCaptionsGrabberApi;

use App\Core\Contracts\Apis\YoutubeCaptionsGrabberApiInterface;
use App\Exceptions\InvalidYoutubeCaptionsFormatException;
use App\Exceptions\YoutubeVideoCaptionsCannotBeFoundException;
use App\Exceptions\YoutubeVideoCaptionsFetchException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class FirstPartyYoutubeCaptionsGrabberApi implements YoutubeCaptionsGrabberApiInterface
{
    public function getCaptions(string $videoId): string
    {
        $response = Http::get(config('app.captions_endpoint').'?source=youtube&id='.$videoId);

        if ($response->status() === Response::HTTP_NOT_FOUND) {
            throw new YoutubeVideoCaptionsCannotBeFoundException($videoId);
        }

        if ($response->status() !== Response::HTTP_OK) {
            throw new YoutubeVideoCaptionsFetchException();
        }
        $jsonRsponse = $response->json();

        if (! isset($jsonRsponse['transcript'])) {
            throw new InvalidYoutubeCaptionsFormatException();
        }

        return json_encode($jsonRsponse['transcript'], JSON_THROW_ON_ERROR);

    }
}
