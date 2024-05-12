<?php

declare(strict_types=1);

namespace App\Factories;

use App\Exceptions\ResourceGenerationInputsAreNullException;
use App\Models\ResourceModels\SrtResourceModel;
use App\Models\ResourceModels\YoutubeResourceModel;
use App\Resources\ResourceInterface;
use App\Resources\SrtFileResource;
use App\Resources\YoutubeUrlResource;
use App\Services\Captions\CaptionsCollection;
use App\Services\SrtParser\BenlippStrParser;
use App\Services\YoutubeCaptionsGrabberApi\FirstPartyYoutubeCaptionsGrabberApi;
use App\Traits\FileResourceTrait;
use Illuminate\Http\UploadedFile;

class ResourceFactory
{
    use FileResourceTrait;

    public function generate(?UploadedFile $file, ?string $videoUrl): ResourceInterface
    {
        if (! is_null($videoUrl)) {
            return new YoutubeUrlResource($videoUrl, new YoutubeResourceModel($videoUrl), new FirstPartyYoutubeCaptionsGrabberApi());
        }
        if (is_null($file)) {
            throw new ResourceGenerationInputsAreNullException();
        }

        return new SrtFileResource(
            $file,
            new SrtResourceModel($file->getRealPath()),
            new BenlippStrParser(new CaptionsCollection())
        );
    }
}
