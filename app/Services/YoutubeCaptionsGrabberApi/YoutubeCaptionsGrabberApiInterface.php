<?php

declare(strict_types=1);

namespace App\Services\YoutubeCaptionsGrabberApi;

interface YoutubeCaptionsGrabberApiInterface
{
    public function getCaptions(string $videoId): string;
}
