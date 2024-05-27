<?php

declare(strict_types=1);

namespace App\Apis\WordsFilterApi;

use App\Core\Contracts\Apis\WordFilterApiInterface;
use App\DataObjects\FilteredWords\FilteredWord;
use App\DataObjects\FilteredWords\FilteredWordCollection;
use App\Exceptions\ResourceWithInvalidTextProvidedException;
use StopWords\StopWords;

class PhpBasedWordFilterApi implements WordFilterApiInterface
{
    public function filter(string $words): FilteredWordCollection
    {
        $words = strtolower($words);
        $words = trim(preg_replace([
            '/\s+/',
            '/\b[\W_]+|[\W_]+\b/',
            '/\d/',
            '/(^|\s+)(\S(\s+|$))+/',
        ], ' ', $words));
        $words = (new StopWords('english'))->clean($words);

        $filteredWords = array_unique(explode(' ', $words), SORT_REGULAR);

        $filteredWordsCollection = new FilteredWordCollection();
        if ($words === '') {
            throw new ResourceWithInvalidTextProvidedException();
        }
        foreach ($filteredWords as $filteredWord) {
            $filteredWordsCollection->add(new FilteredWord($filteredWord));
        }

        return $filteredWordsCollection;
    }
}
