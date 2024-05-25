<?php

declare(strict_types=1);

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class EnhancementBuilder extends Builder
{
    public function createByUserId(int $userId, int $sourceId): Model
    {
        return $this->create([
            'user_id' => $userId,
            'uuid' => Uuid::uuid4(),
            'source_id' => $sourceId]);
    }
}
