<?php

declare(strict_types=1);

namespace App\Resources;

use App\Models\Srt;
use Illuminate\Http\UploadedFile;

class SrtFileResource implements ResourceInterface
{
    public function __construct(private UploadedFile $file)
    {
    }

    public function isAlreadyExist(): bool
    {
        return Srt::query()->where('md5_hash', md5_file($this->file->getRealPath()))->exists();
    }
}
