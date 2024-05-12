<?php

declare(strict_types=1);

namespace App\Models\ResourceModels;

use App\Models\Source;
use App\Models\Srt;

readonly class SrtResourceModel implements ResourceModelInterface
{
    public function __construct(private string $fileRealPath)
    {
    }

    public function resourceExists(): bool
    {
        return Srt::query()
            ->where('md5_hash', md5_file($this->fileRealPath))
            ->exists();
    }

    public function saveToSource(): Source
    {
        return Srt::query()
            ->create([
                'file_location' => $this->fileRealPath,
                'md5_hash' => md5_file($this->fileRealPath), ])
            ->source()
            ->create([]);
    }
}
