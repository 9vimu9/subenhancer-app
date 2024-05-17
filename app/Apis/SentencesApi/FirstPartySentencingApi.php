<?php

declare(strict_types=1);

namespace App\Apis\SentencesApi;

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
            $collection->add(new Sentence($sentenceString, $index));
        }

        return $collection;
    }
}
