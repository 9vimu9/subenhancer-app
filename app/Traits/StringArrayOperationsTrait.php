<?php

declare(strict_types=1);

namespace App\Traits;

trait StringArrayOperationsTrait
{
    public function getIncludedFilteredWordsInTheSentence(string $text, array $filteredWordsWithIdsArray): array
    {
        $text = $this->processText($text);
        $containedWords = [];
        array_walk($filteredWordsWithIdsArray, static function ($word) use (&$containedWords, $text) {
            if (str_contains($text, strtolower($word['word']))) {//need improvement
                $containedWords[] = $word;
            }
        });

        return $containedWords;
    }

    private function processText(string $text): string
    {
        $text = strtolower($text);
        $text = str_replace(['<', '>', '[', ']', '{', '}', '(', ')'], ' ', $text);
        $text = preg_replace('/\s+/', ' ', $text);

        return preg_replace('/[^a-zA-Z0-9\s]/', '', $text);
    }
}
