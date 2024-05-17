<?php

declare(strict_types=1);

namespace App\Models\ResourceModels;

use App\Core\Contracts\ResourceModels\AbstractResourceModel;
use App\Models\Srt;
use Illuminate\Database\Eloquent\Model;

class SrtResourceModel extends AbstractResourceModel
{
    public function __construct(private readonly string $fileRealPath)
    {
    }

    public function resourceExists(): bool
    {
        return Srt::query()
            ->where('md5_hash', md5_file($this->fileRealPath))
            ->exists();
    }

    public function save(): Model
    {
        return Srt::query()
            ->create([
                'file_location' => $this->fileRealPath,
                'md5_hash' => md5_file($this->fileRealPath)]);
    }

    public function getSource(): Model
    {
        return Srt::query()
            ->where('md5_hash', md5_file($this->fileRealPath))
            ->firstOrFail();
    }
}
