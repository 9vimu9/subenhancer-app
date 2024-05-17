<?php

declare(strict_types=1);

namespace App\Resources;

use App\DataObjects\Captions\Caption;
use App\DataObjects\Captions\CaptionsCollection;
use App\Exceptions\InvalidYoutubeCaptionException;
use App\Models\ResourceModels\ResourceModelInterface;
use App\Services\YoutubeCaptionsGrabberApi\YoutubeCaptionsGrabberApiInterface;
use App\Traits\YoutubeTrait;

class YoutubeUrlResource extends AbstractUrlResource
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
            $caption = new Caption();
            if (! isset($cap['text'], $cap['end'], $cap['start'])) {
                throw new InvalidYoutubeCaptionException();
            }
            $caption->setCaption($cap['text']);
            $caption->setEndTime($cap['end']);
            $caption->setStartTime($cap['start']);
            $captionCollection->add($caption);
        }

        return $captionCollection;
    }
}
