<?php

declare(strict_types=1);

namespace App\Services;

use App\DataObjects\Captions\CaptionsCollection;
use App\DataObjects\FilteredWords\FilteredWordCollection;

interface WordServiceInterface
{
    public function storeWordsByCollection(FilteredWordCollection $filteredWordCollection): void;

    public function filterWordsByCollection(CaptionsCollection $captionsCollection): FilteredWordCollection;
}
