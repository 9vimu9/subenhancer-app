<?php

declare(strict_types=1);

namespace App\Traits;

use App\Exceptions\IncorrectYoutubeVideoLinkProvidedException;

trait YoutubeTrait
{
    const REG_EX = '/.*(?:(?:youtu\.be\/|v\/|vi\/\w\/|embed\/)|(?:(?:watch)?\?v(?:i)?=|\&v(?:i)?=))([^#\&\?]*).*/';

    public function getVideoId(string $videoUrl): string
    {
        $matches = [];
        preg_match(self::REG_EX, $videoUrl, $matches);
        if (count($matches) < 2) {
            throw new IncorrectYoutubeVideoLinkProvidedException();
        }

        return (string) $matches[1];
    }
}
