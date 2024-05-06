<?php

declare(strict_types=1);

namespace App\Resources;

use App\Services\Subtitles\CaptionsCollection;

interface ResourceInterface
{
    public function isAlreadyExist(): bool;

    public function fetch(): string;

    public function toCaptions(string $captionsString): CaptionsCollection;

    public function storeResourceTable(): void;
}
