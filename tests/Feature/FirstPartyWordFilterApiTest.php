<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Exceptions\CaptionWordFilterException;
use App\Services\FilteredWords\FilteredWord;
use App\Services\FilteredWords\FilteredWordCollection;
use App\Services\WordsFilterApi\FirstPartyWordFilterApi;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class FirstPartyWordFilterApiTest extends TestCase
{
    public function test_filter_method(): void
    {
        $url = config('app.nlp_endpoint') . 'filter';
        $response = ['filtered_words' => ['aa', 'bb', 'cc']];
        Http::fake([
            $url => Http::response($response, Response::HTTP_OK),

        ]);
        $filteredWordCollection = new FilteredWordCollection();
        $filteredWordCollection->addFilteredWord(new FilteredWord('aa'));
        $filteredWordCollection->addFilteredWord(new FilteredWord('bb'));
        $filteredWordCollection->addFilteredWord(new FilteredWord('cc'));
        $this->assertEquals($filteredWordCollection, (new FirstPartyWordFilterApi())->filter('RANDOM_TEXT'));

    }

    public function test_exception_must_be_thrown_when_the_filter_service_is_not_functional(): void
    {
        $url = config('app.nlp_endpoint') . 'filter';
        Http::fake([
            $url => Http::sequence()->pushStatus(Response::HTTP_INTERNAL_SERVER_ERROR),
        ]);
        $this->expectException(CaptionWordFilterException::class);
        (new FirstPartyWordFilterApi())->filter('RANDOM_TEXT');
    }
}
