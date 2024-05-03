<?php

declare(strict_types=1);

namespace App\Factories;

use App\Exceptions\ResourceGenerationInputsAreNullException;
use App\Resources\ResourceInterface;
use App\Resources\SrtFileResource;
use App\Resources\YoutubeUrlResource;
use Illuminate\Http\UploadedFile;

class ResourceFactory
{
    public function generate(?UploadedFile $file, ?string $videoUrl): ResourceInterface
    {
        if (! is_null($videoUrl)) {
            return $this->generateVideoUrlResource($videoUrl);
        }
        if (is_null($file)) {
            throw new ResourceGenerationInputsAreNullException();
        }

        return $this->generateSubtitleFileResource($file);

    }

    private function generateVideoUrlResource(string $videoUrl): ResourceInterface
    {
        return new YoutubeUrlResource();

    }

    private function generateSubtitleFileResource(UploadedFile $file): ResourceInterface
    {
        return new SrtFileResource();

    }
}
