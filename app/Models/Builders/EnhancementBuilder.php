<?php

declare(strict_types=1);

namespace App\Models\Builders;

use App\Exceptions\EnhancementCannotBeFoundException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class EnhancementBuilder extends Builder
{
    public function createByUserId(int $userId): Model
    {
        return $this->create(['user_id' => $userId, 'uuid' => Uuid::uuid4()]);
    }

    public function updateSourceId(int $enhancementId, int $sourceId): void
    {
        $enhancement = $this->find($enhancementId);
        if (is_null($enhancement)) {
            throw new EnhancementCannotBeFoundException();
        }
        $enhancement->update(['source_id' => $sourceId]);
    }
}
