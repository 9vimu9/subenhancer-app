<?php

declare(strict_types=1);

namespace App\Core\Contracts\Services;

interface VocabularyServiceInterface
{
    public function updateVocabularyBySource(int $sourceId);
}
