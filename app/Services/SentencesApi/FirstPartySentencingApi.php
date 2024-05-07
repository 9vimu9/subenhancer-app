<?php

declare(strict_types=1);

namespace App\Services\SentencesApi;

use App\Exceptions\SentencingApiErrorException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class FirstPartySentencingApi implements SentencesApiInterface
{
    public function getSentences(string $caption): array
    {
        $url = config('app.sentencing_endpoint');
        $response = Http::post($url, ['caption_string' => $caption]);
        if ($response->status() !== Response::HTTP_OK) {
            throw new SentencingApiErrorException();
        }

        return $response->json()['sentences'];

    }
}
