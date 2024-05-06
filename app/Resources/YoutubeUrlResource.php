<?php

declare(strict_types=1);

namespace App\Resources;

use App\Exceptions\IncorrectYoutubeVideoLinkProvidedException;
use App\Exceptions\InvalidYoutubeCaptionException;
use App\Exceptions\YoutubeVideoCaptionsFetchException;
use App\Models\Source;
use App\Models\Youtubevideo;
use App\Services\Captions\Caption;
use App\Services\Captions\CaptionsCollection;
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

    public function toCaptions(string $captionsString): CaptionsCollection
    {
        $captionCollection = new CaptionsCollection();
        $captions = json_decode($captionsString, true, 512, JSON_THROW_ON_ERROR);
        foreach ($captions as $cap) {
            $caption = new Caption();
            if (! isset($cap['text'], $cap['end'], $cap['start'])) {
                throw new InvalidYoutubeCaptionException();
            }
            $caption->setCaption($cap['text']);
            $caption->setEndTime($cap['end']);
            $caption->setStartTime($cap['start']);
            $captionCollection->addCaption($caption);
        }

        return $captionCollection;
    }

    public function storeResourceTable(): Source
    {
        $youtube = Youtubevideo::query()->create(['video_id' => $this->getVideoId()]);

        return $youtube->source()->create([]);
    }
}
