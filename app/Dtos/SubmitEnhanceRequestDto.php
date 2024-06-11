<?php

declare(strict_types=1);

namespace App\Dtos;

use App\Core\Contracts\Dtos\Arrayable;
use App\Core\Contracts\Dtos\Dto;
use Illuminate\Http\UploadedFile;

readonly class SubmitEnhanceRequestDto implements Arrayable, Dto
{
    public function __construct(
        public string $name,
        public ?UploadedFile $subtitleFile,
        public ?string $videoUrl
    ) {
    }

    public function toArray(): array
    {
        return
            [
                'name' => $this->name,
                'subtitle_file' => $this->subtitleFile,
                'video_url' => $this->videoUrl,
            ];
    }
}
