<?php

declare(strict_types=1);

namespace App\Resources;

use App\Core\Contracts\Apis\YoutubeCaptionsGrabberApiInterface;
use App\Core\Contracts\Resource\AbstractResource;
use App\Core\Contracts\ResourceModels\ResourceModelInterface;
use App\DataObjects\Captions\Caption;
use App\DataObjects\Captions\CaptionsCollection;
use App\Exceptions\InvalidYoutubeCaptionException;
use App\Traits\YoutubeTrait;

class YoutubeUrlResource extends AbstractResource
{
    use YoutubeTrait;

    public function __construct(
        protected string $videoUrl,
        protected ResourceModelInterface $resourceModel,
        protected YoutubeCaptionsGrabberApiInterface $captionsGrabberApi
    ) {
    }

    public function toCaptions(): CaptionsCollection
    {
        $captionCollection = new CaptionsCollection();
        $captions = json_decode($this->captionsGrabberApi->getCaptions($this->getVideoId($this->videoUrl)), true, 512, JSON_THROW_ON_ERROR);
        foreach ($captions as $cap) {
            if (! isset($cap['text'], $cap['end'], $cap['start'])) {
                throw new InvalidYoutubeCaptionException($cap);
            }
            $captionCollection->add(
                new Caption(
                    captionString: $cap['text'],
                    startTime: $cap['start'],
                    endTime: $cap['end'],
                )
            );
        }

        return $captionCollection;
    }
}
