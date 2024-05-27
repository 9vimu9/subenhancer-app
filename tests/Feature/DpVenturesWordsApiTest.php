<?php

declare(strict_types=1);

namespace Feature;

use App\Apis\DefinitionsAPI\DpVenturesWordsApi;
use App\DataObjects\Definitions\Definition;
use App\Enums\WordClassEnum;
use App\Exceptions\CantFindDefinitionException;
use App\Exceptions\DefinitionsApiErrorException;
use App\Exceptions\InvalidDefinitionResponseFormatException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class DpVenturesWordsApiTest extends TestCase
{
    public function test_free_dictionary_api_get_definition_method(): void
    {
        $word = 'hello';
        $url = config('app.definition_apis.dp_ventures.endpoint').$word.'/definitions';
        $response = [
            'word' => 'hello',
            'definitions' => [
                [
                    'definition' => 'an expression of greeting.',
                    'partOfSpeech' => 'noun',
                ],
            ],
        ];

        Http::fake([
            $url => Http::response($response, Response::HTTP_OK),

        ]);
        $definitionCollection = (new DpVenturesWordsApi())->getDefinitions($word);
        $definitionsArray = [
            new Definition(WordClassEnum::NOUN, 'an expression of greeting.', $word),
        ];
        $this->assertEqualsCanonicalizing($definitionsArray, iterator_to_array($definitionCollection->getIterator()));
    }

    public function test_throws_exception_when_meanings_cannot_be_found(): void
    {
        $word = 'RANDOM';
        $url = config('app.definition_apis.dp_ventures.endpoint').$word.'/definitions';
        Http::fake([
            $url => Http::response(null, Response::HTTP_NOT_FOUND),
        ]);
        $this->expectException(CantFindDefinitionException::class);
        (new DpVenturesWordsApi())->getDefinitions($word);

    }

    public function test_throws_exception_when_definition_api_not_functional(): void
    {
        $word = 'RANDOM';
        $url = config('app.definition_apis.dp_ventures.endpoint').$word.'/definitions';
        Http::fake([
            $url => Http::response(null, Response::HTTP_INTERNAL_SERVER_ERROR),
        ]);
        $this->expectException(DefinitionsApiErrorException::class);
        (new DpVenturesWordsApi())->getDefinitions($word);

    }

    public static function invalidResponses(): array
    {
        return [
            'without definitions' => [
                [
                    'word' => 'hello',
                ],
            ],

            'without definition' => [
                [
                    'word' => 'hello',
                    'definitions' => [
                        [
                            'partOfSpeech' => 'noun',
                        ],
                    ],
                ],
            ],
            'without part of speech' => [
                [
                    'word' => 'hello',
                    'definitions' => [
                        [
                            'definition' => 'an expression of greeting.',
                        ],
                    ],
                ],
            ],
        ];
    }

    #[DataProvider('invalidResponses')]
    public function test_invalid_formats(array $invalidResponse): void
    {
        $word = 'RANDOM';
        $url = config('app.definition_apis.dp_ventures.endpoint').$word.'/definitions';
        Http::fake([
            $url => Http::response($invalidResponse, Response::HTTP_OK),
        ]);
        $this->expectException(InvalidDefinitionResponseFormatException::class);
        (new DpVenturesWordsApi())->getDefinitions($word);
    }
}
