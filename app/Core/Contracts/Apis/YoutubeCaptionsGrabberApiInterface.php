<?php

declare(strict_types=1);

namespace App\Core\Contracts\Apis;

interface YoutubeCaptionsGrabberApiInterface
{
    public function getCaptions(string $videoId): string;
}
