<?php

declare(strict_types=1);

namespace App\Models\Builders;

use App\Enums\VocabularyEnum;
use App\Exceptions\UserHasNotBeenAuthenticatedException;
use Illuminate\Database\Eloquent\Builder;

class VocabularyBuilder extends Builder
{
    public function store(VocabularyEnum $type, int $definitionId, ?int $userId = null): void
    {
        $this->create([
            'definition_id' => $definitionId,
            'user_id' => $userId ?? auth()->id() ?? throw new UserHasNotBeenAuthenticatedException(),
            'vocabulary_type' => $type->name,
        ]);

    }

    public function alreadyIncludedForTheUser(int $definitionId, ?int $userId = null): bool
    {
        return $this->where('definition_id', $definitionId)
            ->where('user_id',
                $userId ?? auth()->id() ?? throw new UserHasNotBeenAuthenticatedException())
            ->exists();
    }
}
