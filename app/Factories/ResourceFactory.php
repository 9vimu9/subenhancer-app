<?php

declare(strict_types=1);

namespace App\Factories;

use App\Core\Contracts\Apis\SrtParserInterface;
use App\Core\Contracts\Apis\YoutubeCaptionsGrabberApiInterface;
use App\Core\Contracts\Resource\ResourceInterface;
use App\Exceptions\ResourceGenerationInputsAreNullException;
use App\Models\ResourceModels\SrtResourceModel;
use App\Models\ResourceModels\YoutubeResourceModel;
use App\Resources\SrtFileResource;
use App\Resources\YoutubeUrlResource;
use App\Traits\FileResourceTrait;
use Illuminate\Http\UploadedFile;

class ResourceFactory
{
    use FileResourceTrait;

    public function generate(?UploadedFile $file, ?string $videoUrl, SrtParserInterface $srtParser, YoutubeCaptionsGrabberApiInterface $youtubeCaptionsGrabberApi): ResourceInterface
    {
        if (! is_null($videoUrl)) {
            return new YoutubeUrlResource($videoUrl, new YoutubeResourceModel($videoUrl), $youtubeCaptionsGrabberApi);
        }
        if (is_null($file)) {
            throw new ResourceGenerationInputsAreNullException();
        }

        return new SrtFileResource(
            $file,
            new SrtResourceModel($file->getRealPath()),
            $srtParser);

    }
}
