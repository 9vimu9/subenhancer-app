<?php

declare(strict_types=1);

namespace App\Services\Subtitles;

use App\Exceptions\CaptionWordFilterException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class CaptionsCollection
{
    private array $captions = [];

    public function addCaption(Caption $caption): void
    {
        $this->captions[] = $caption;
    }

    public function captions(): array
    {
        return $this->captions;
    }

    //list of unique words that is included in captions.
    // This list should not be included duplicate words, stop words, nouns like place names
    public function getFilteredWords()
    {
        $url = config('app.nlp_endpoint').'filter';
        $response = Http::post($url, ['caption_string' => $this->toString()]);
        if ($response->status() !== Response::HTTP_OK) {
            throw new CaptionWordFilterException();
        }

        return $response->json()['filtered_words'];
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
