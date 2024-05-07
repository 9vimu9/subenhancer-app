<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Services\SentencesApi\FirstPartySentencingApi;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class FirstPartySentencingApiTest extends TestCase
{
    public function test_get_sentences(): void
    {
        $url = config('app.sentencing_endpoint');
        $response = ['sentences' => ['sentence_1', 'sentence_2']];
        Http::fake([
            $url => Http::response($response, Response::HTTP_OK),

        ]);
        $sentences = (new FirstPartySentencingApi())->getSentences('RANDOMS');
        $this->assertEquals($response['sentences'], $sentences);
    }
}
