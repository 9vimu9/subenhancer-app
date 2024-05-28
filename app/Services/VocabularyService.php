<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Contracts\Services\VocabularyServiceInterface;
use App\DataObjects\DefinedWords\DefinedWord;
use App\DataObjects\DefinedWords\DefinedWordCollection;
use App\Enums\VocabularyEnum;
use App\Exceptions\VocabularyNotFoundWithDefinitionForUserException;
use App\Models\Captionword;
use App\Models\Vocabulary;

class VocabularyService implements VocabularyServiceInterface
{
    public function updateVocabularyBySource(int $sourceId): void
    {
        $userId = auth()->id();
        Captionword::query()->getWordsBySourceId($sourceId, ['definition_id'])->each(function (Captionword $word) use ($userId) {
            $definitionId = $word->getAttribute('definition_id');
            Vocabulary::query()->firstOrCreate(
                ['definition_id' => $definitionId, 'user_id' => $userId],
                ['definition_id' => $definitionId, 'user_id' => $userId, 'vocabulary_type' => VocabularyEnum::HAVE_NOT_SPECIFIED->name],
            );
        });

    }

    public function getVocabularyBySource(int $sourceId): DefinedWordCollection
    {
        $definedWords = new DefinedWordCollection();
        $userId = auth()->id();
        Captionword::query()->getWordsBySourceId($sourceId, ['definition_id'])->each(function (Captionword $captionword) use ($userId, $definedWords) {
            try {
                Vocabulary::query()->findOrFailByDefinitionIdForUser($captionword->definition_id, $userId);
                $definedWords->add(new DefinedWord($captionword));
            } catch (VocabularyNotFoundWithDefinitionForUserException $exception) {
                return true;
            }
        });

        return $definedWords;
    }
}
