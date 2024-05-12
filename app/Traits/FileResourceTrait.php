<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Http\UploadedFile;

trait FileResourceTrait
{
    public function relocateFile(UploadedFile $file): UploadedFile
    {
        $hashedFileName = $file->hashName();
        $movedFile = $file->move(storage_path('app'), $hashedFileName);

        return new UploadedFile($movedFile->getRealPath(), $hashedFileName);
    }
}
