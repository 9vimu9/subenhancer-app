<?php

declare(strict_types=1);

namespace App\Core\Contracts\Services;

use App\DataObjects\Captions\CaptionsCollection;
use App\DataObjects\FilteredWords\FilteredWordCollection;

interface WordServiceInterface
{
    public function processWordsByCollection(CaptionsCollection $captionsCaptionsCollection): FilteredWordCollection;
}
