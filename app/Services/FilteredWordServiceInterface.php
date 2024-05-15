<?php

declare(strict_types=1);

namespace App\Services;

use App\Services\Sentences\Sentence;

interface FilteredWordServiceInterface
{
    public function saveFilteredWordWhichFoundInSentence(
        array $filteredWordArray,
        Sentence $sentence,
        int $sentenceId): void;
}
