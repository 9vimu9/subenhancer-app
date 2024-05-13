<?php

declare(strict_types=1);

namespace App\Services\WordsFilterApi;

use App\Exceptions\CaptionWordFilterException;
use App\Services\FilteredWords\FilteredWord;
use App\Services\FilteredWords\FilteredWordCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class FirstPartyWordFilterApi implements WordFilterApiInterface
{
    public function filter(string $words): FilteredWordCollection
    {
        $url = config('app.nlp_endpoint').'filter';
        $response = Http::post($url, ['caption_string' => $words]);
        if ($response->status() !== Response::HTTP_OK) {
            throw new CaptionWordFilterException();
        }
        $filteredWords = $response->json()['filtered_words'];
        $filteredWordsCollection = new FilteredWordCollection();
        foreach ($filteredWords as $filteredWord) {
            $filteredWordsCollection->add(new FilteredWord($filteredWord));
        }

        return $filteredWordsCollection;

    }
}
