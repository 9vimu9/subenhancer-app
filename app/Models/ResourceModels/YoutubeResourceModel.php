<?php

declare(strict_types=1);

namespace App\Models\ResourceModels;

use App\Models\Source;
use App\Models\Youtubevideo;
use App\Traits\YoutubeTrait;

class YoutubeResourceModel implements ResourceModelInterface
{
    use YoutubeTrait;

    private string $videoId;

    public function __construct(private readonly string $videoUrl)
    {
        $this->videoId = $this->getVideoId($this->videoUrl);
    }

    public function resourceExists(): bool
    {
        return Youtubevideo::query()->where('video_id', $this->videoId)->exists();
    }

    public function saveToSource(): Source
    {
        return Youtubevideo::query()
            ->create(['video_id' => $this->videoId])
            ->source()
            ->create([]);
    }
}
