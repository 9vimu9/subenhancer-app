<?php

declare(strict_types=1);

namespace App\Resources;

use Illuminate\Http\UploadedFile;

interface FileResourceInterface
{
    public function getFile(): UploadedFile;

    public function relocateFile(): void;
}
