<?php

declare(strict_types=1);

namespace App\Services\Captions;

use App\Exceptions\CaptionWordFilterException;
use App\Services\FilteredWords\FilteredWord;
use App\Services\FilteredWords\FilteredWordCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class CaptionsCollection
{
    /**
     * @template T of Caption
     *
     * @var array<int, T>
     */
    private array $captions = [];

    public function addCaption(Caption $caption): void
    {
        $this->captions[] = $caption;
    }

    /**
     * @template T of Caption
     *
     * @return array<int, T>
     */
    public function captions(): array
    {
        return $this->captions;
    }

    //list of unique words that is included in captions.
    // This list should not be included duplicate words, stop words, nouns like place names
    public function getFilteredWords(): FilteredWordCollection
    {
        $url = config('app.nlp_endpoint').'filter';
        $response = Http::post($url, ['caption_string' => $this->toString()]);
        if ($response->status() !== Response::HTTP_OK) {
            throw new CaptionWordFilterException();
        }
        $filteredWords = $response->json()['filtered_words'];
        $filteredWordsCollection = new FilteredWordCollection();
        foreach ($filteredWords as $filteredWord) {
            $filteredWordsCollection->addFilteredWord(new FilteredWord($filteredWord));
        }

        return $filteredWordsCollection;
    }

    public function toString(): string
    {
        $captionsStrings = '';
        foreach ($this->captions as $caption) {
            $captionsStrings .= $caption->getCaption();
        }

        return $captionsStrings;
    }
}
