<?php

declare(strict_types=1);

namespace App\Services\SentencesApi;

use App\DataObjects\Sentences\Sentence;
use App\DataObjects\Sentences\SentenceCollection;
use App\Exceptions\SentencingApiErrorException;
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
            $collection->add($sentence);
        }

        return $collection;
    }
}
