<?php

declare(strict_types=1);

namespace App\Resources;

use App\Exceptions\IncorrectYoutubeVideoLinkProvidedException;
use App\Exceptions\YoutubeVideoCaptionsFetchException;
use App\Models\Youtubevideo;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class YoutubeUrlResource implements ResourceInterface
{
    const REG_EX = '/.*(?:(?:youtu\.be\/|v\/|vi\/\w\/|embed\/)|(?:(?:watch)?\?v(?:i)?=|\&v(?:i)?=))([^#\&\?]*).*/';

    public function __construct(private string $videoUrl)
    {
    }

    public function isAlreadyExist(): bool
    {
        return Youtubevideo::query()->where('video_id', $this->getVideoId())->exists();
    }

    private function getVideoId(): string
    {
        $matches = [];
        preg_match(self::REG_EX, $this->videoUrl, $matches);
        if (count($matches) < 2) {
            throw new IncorrectYoutubeVideoLinkProvidedException();
        }

        return (string) $matches[1];

    }

    public function fetch(): string
    {
        $url = config('app.captions_endpoint').'?source=youtube&id='.$this->getVideoId();
        $response = Http::get($url);
        if ($response->status() !== Response::HTTP_OK) {
            throw new YoutubeVideoCaptionsFetchException();
        }

        return json_encode($response->json()['transcript'], JSON_THROW_ON_ERROR);
    }
}
