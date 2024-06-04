<?php

declare(strict_types=1);

namespace App\Traits;

use App\Dtos\CorpusDto;
use App\Dtos\CorpusDtoCollection;

trait StringArrayOperationsTrait
{
    public function getIncludedFilteredWordsInTheSentence(
        string $text,
        CorpusDtoCollection $filteredWordsDtoCollection): CorpusDtoCollection
    {
        $text = $this->processText($text);

        return new CorpusDtoCollection(...array_filter($filteredWordsDtoCollection->items(),
            static function (CorpusDto $dto) use ($text) {
                return str_contains($text, strtolower($dto->word));
            }));

    }

    private function processText(string $text): string
    {
        $text = strtolower($text);
        $text = str_replace(['<', '>', '[', ']', '{', '}', '(', ')'], ' ', $text);
        $text = preg_replace('/\s+/', ' ', $text);

        return preg_replace('/[^a-zA-Z0-9\s]/', '', $text);
    }
}
