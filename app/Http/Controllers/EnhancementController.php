<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\Contracts\Services\VocabularyServiceInterface;

class EnhancementController extends Controller
{
    public function show(string $enhancementId, VocabularyServiceInterface $vocabularyService)
    {
        $definedWordsCollection = $vocabularyService->getUserVocabularyByEnhancement(
            $enhancementId,
            auth()->id()
        );
        dd($definedWordsCollection);
    }
}
