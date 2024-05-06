<?php

declare(strict_types=1);

namespace App\Services;

use App\Factories\ResourceFactory;
use App\Models\Enhancement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class EnhancementService
{
    public function create(int $userId): Model
    {
        return Enhancement::query()->create(['user_id' => $userId, 'uuid' => Str::uuid()]);
    }

    public function updateSourceId(int $enhancementId, int $sourceId): void
    {
        $enhancement = Enhancement::query()->findOrFail($enhancementId);
        $enhancement->update(['source_id' => $sourceId]);
    }

    public function submitEnhancement(?UploadedFile $file, ?string $videoUrl): void
    {
        $this->create(auth()->id());
        $resource = (new ResourceFactory())->generate($file, $videoUrl);
        if ($resource->isAlreadyExist()) {
        }
        $captionsCollection = $resource->toCaptions($resource->fetch());
        $resource->storeResourceTable();
    }
}
