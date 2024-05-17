<?php

declare(strict_types=1);

namespace App\Models\ResourceModels;

use App\Core\Contracts\ResourceModels\AbstractResourceModel;
use App\Models\Youtubevideo;
use App\Traits\YoutubeTrait;
use Illuminate\Database\Eloquent\Model;

class YoutubeResourceModel extends AbstractResourceModel
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

    public function save(): Model
    {
        return Youtubevideo::query()
            ->create(['video_id' => $this->videoId]);
    }

    public function getSource(): Model
    {
        return Youtubevideo::query()->where('video_id', $this->videoId)->firstOrFail();
    }
}
