<?php

declare(strict_types=1);

namespace App\Core\Contracts\Services;

use Illuminate\Database\Eloquent\Collection;

interface VocabularyServiceInterface
{
    public function updateVocabularyBySource(int $sourceId);

    public function getVocabularyBySource(int $sourceId): Collection;
}
