<?php

declare(strict_types=1);

namespace App\Models\Builders;

use App\Core\Database\CustomBuilder;
use App\Dtos\EnhancementCreateDto;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class EnhancementBuilder extends CustomBuilder
{
    public function createByUserId(EnhancementCreateDto $dto): Model
    {
        return $this->create([
            'name' => $dto->name,
            'user_id' => $dto->userId,
            'uuid' => Uuid::uuid4(),
            'source_id' => $dto->sourceId, ]);
    }
}
