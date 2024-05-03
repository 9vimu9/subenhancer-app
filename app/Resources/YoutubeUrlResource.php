<?php

declare(strict_types=1);

namespace App\Resources;

use App\Exceptions\IncorrectYoutubeVideoLinkProvidedException;
use App\Models\Youtubevideo;

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
}
