<?php

declare(strict_types=1);

namespace App\Models\Builders;

use App\Enums\VocabularyEnum;
use App\Exceptions\UserHasNotBeenAuthenticatedException;

class VocabularyBuilder
{
    public function store(VocabularyEnum $type, int $definitionId, ?int $userId): void
    {
        $this->create([
            'definition_id' => $definitionId,
            'user_id' => $userId ?? auth()->id() ?? throw new UserHasNotBeenAuthenticatedException(),
            'type' => $type->name,
        ]);

    }

    public function alreadyIncludedForTheUser(int $definitionId, ?int $userId): bool
    {
        return $this->where('definition_id', $definitionId)
            ->where('user_id',
                $userId ?? auth()->id() ?? throw new UserHasNotBeenAuthenticatedException())
            ->exists();
    }
}
