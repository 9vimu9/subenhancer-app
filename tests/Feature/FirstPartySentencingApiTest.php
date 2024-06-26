<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Apis\SentencesApi\FirstPartySentencingApi;
use App\DataObjects\Sentences\Sentence;
use App\DataObjects\Sentences\SentenceCollection;
use App\Exceptions\SentencingApiErrorException;
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

        $collection = new SentenceCollection(
            new Sentence(sentence: 'sentence_1', order: 0),
            new Sentence(sentence: 'sentence_2', order: 1)
        );

        $this->assertEqualsCanonicalizing(iterator_to_array($collection->getIterator()), iterator_to_array($sentences->getIterator()));
    }

    public function test_exception_must_be_thrown_when_api_is_not_OK(): void
    {
        $url = config('app.sentencing_endpoint');
        Http::fake([
            $url => Http::response([], Response::HTTP_INTERNAL_SERVER_ERROR),
        ]);
        $this->expectException(SentencingApiErrorException::class);
        (new FirstPartySentencingApi())->getSentences('RANDOMS');
    }
}
