<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\Contracts\Services\VocabularyServiceInterface;

class EnhancementController extends Controller
{
    public function show(string $enhancementUuid, VocabularyServiceInterface $vocabularyService)
    {
        $definedWordsCollection = $vocabularyService->getUserVocabularyByEnhancement(
            $enhancementUuid,
            auth()->id()
        );

        return json_encode($definedWordsCollection->toArray());
    }
}
