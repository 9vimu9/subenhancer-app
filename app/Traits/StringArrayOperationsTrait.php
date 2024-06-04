<?php

declare(strict_types=1);

namespace App\Traits;

use App\Dtos\CorpusDtoCollection;

trait StringArrayOperationsTrait
{
    public function getIncludedFilteredWordsInTheSentence(string $text, CorpusDtoCollection $filteredWordsDtoCollection): CorpusDtoCollection
    {
        $text = $this->processText($text);
        $containedWordsDtoCollection = new CorpusDtoCollection();
        foreach ($filteredWordsDtoCollection as $filteredWord) {
            if (str_contains($text, strtolower($filteredWord->word))) {
                $containedWordsDtoCollection->add($filteredWord);
            }
        }

        return $containedWordsDtoCollection;
    }

    private function processText(string $text): string
    {
        $text = strtolower($text);
        $text = str_replace(['<', '>', '[', ']', '{', '}', '(', ')'], ' ', $text);
        $text = preg_replace('/\s+/', ' ', $text);

        return preg_replace('/[^a-zA-Z0-9\s]/', '', $text);
    }
}
