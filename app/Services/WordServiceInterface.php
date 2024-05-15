<?php

declare(strict_types=1);

namespace App\Services;

use App\Services\Captions\CaptionsCollection;
use App\Services\FilteredWords\FilteredWordCollection;

interface WordServiceInterface
{
    public function storeWordsByCollection(FilteredWordCollection $filteredWordCollection): void;

    public function filterWordsByCollection(CaptionsCollection $captionsCollection): FilteredWordCollection;
}
