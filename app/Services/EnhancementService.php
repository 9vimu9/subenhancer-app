<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Enhancement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EnhancementService
{
    public function create(int $userId): Model
    {
        return Enhancement::query()->create(['user_id' => $userId, 'uuid' => Str::uuid()]);
    }
}
