<?php

declare(strict_types=1);

namespace App\Models\Builders;

use App\Enums\VocabularyEnum;
use App\Exceptions\UserHasNotBeenAuthenticatedException;
use App\Exceptions\VocabularyNotFoundWithDefinitionForUserException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

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
        try {
            $this->findOrFailByDefinitionIdForUser($definitionId, $userId);

            return true;
        } catch (VocabularyNotFoundWithDefinitionForUserException $exception) {
            return false;
        }
    }

    public function findOrFailByDefinitionIdForUser(int $definitionId, ?int $userId = null, $columns = ['id']): Model
    {
        return $this->where('definition_id', $definitionId)
            ->where('user_id',
                $userId ?? auth()->id() ?? throw new UserHasNotBeenAuthenticatedException()
            )->first($columns)
            ??
            throw new VocabularyNotFoundWithDefinitionForUserException();
    }
}
