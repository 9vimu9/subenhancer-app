<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Exceptions\CaptionWordFilterException;
use App\Services\Subtitles\CaptionsCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CaptionsCollectionTest extends TestCase
{
    public function test_getfilteredword_method(): void
    {
        $url = config('app.nlp_endpoint').'filter';
        $response = ['filtered_words' => ['aa', 'bb', 'cc']];
        Http::fake([
            $url => Http::response($response, Response::HTTP_OK),

        ]);
        $captionsCollection = new CaptionsCollection();
        $this->assertEquals($response['filtered_words'], $captionsCollection->getFilteredWords());

    }

    public function test_exception_must_be_thrown_when_the_filter_service_is_not_functional(): void
    {

        $url = config('app.nlp_endpoint').'filter';
        Http::fake([
            $url => Http::sequence()->pushStatus(Response::HTTP_INTERNAL_SERVER_ERROR),
        ]);
        $this->expectException(CaptionWordFilterException::class);
        (new CaptionsCollection())->getFilteredWords();
    }
}
