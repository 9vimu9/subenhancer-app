<?php

declare(strict_types=1);

namespace App\Core\Contracts\Apis;

use App\DataObjects\FilteredWords\FilteredWordCollection;

interface WordFilterApiInterface
{
    //list of unique words that is included in captions.
    // This list should not be included duplicate words, stop words, nouns like place names
    public function filter(string $words): FilteredWordCollection;
}
