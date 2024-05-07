<?php

declare(strict_types=1);

namespace App\Services\SentencesApi;

use App\Exceptions\SentencingApiErrorException;
use App\Services\Sentences\Sentence;
use App\Services\Sentences\SentenceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class FirstPartySentencingApi implements SentencesApiInterface
{
    public function getSentences(string $caption): SentenceCollection
    {
        $url = config('app.sentencing_endpoint');
        $response = Http::post($url, ['caption_string' => $caption]);
        if ($response->status() !== Response::HTTP_OK) {
            throw new SentencingApiErrorException();
        }

        $collection = new SentenceCollection();
        foreach ($response->json()['sentences'] as $index => $sentenceString) {
            $sentence = new Sentence();
            $sentence->setSentence($sentenceString);
            $sentence->setOrder($index);
            $collection->addSentence($sentence);
        }

        return $collection;
    }
}
