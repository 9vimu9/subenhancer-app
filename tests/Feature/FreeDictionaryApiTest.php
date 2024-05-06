<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\WordClassEnum;
use App\Exceptions\InvalidWordClassFoundException;
use App\Services\Definitions\Definition;
use App\Services\DefinitionsAPI\FreeDictionaryApi;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class FreeDictionaryApiTest extends TestCase
{
    public function test_free_dictionary_api_get_definition_method(): void
    {
        $url = config('app.definition_apis.free_dictionary_api').'hello';
        $response = [
            [
                'word' => 'hello',
                'phonetics' => [
                    [
                        'audio' => 'https://api.dictionaryapi.dev/media/pronunciations/en/hello-au.mp3',
                        'sourceUrl' => 'https://commons.wikimedia.org/w/index.php?curid=75797336',
                        'license' => [
                            'name' => 'BY-SA 4.0',
                            'url' => 'https://creativecommons.org/licenses/by-sa/4.0',
                        ],
                    ],
                    [
                        'text' => '/həˈləʊ/',
                        'audio' => 'https://api.dictionaryapi.dev/media/pronunciations/en/hello-uk.mp3',
                        'sourceUrl' => 'https://commons.wikimedia.org/w/index.php?curid=9021983',
                        'license' => [
                            'name' => 'BY 3.0 US',
                            'url' => 'https://creativecommons.org/licenses/by/3.0/us',
                        ],
                    ],
                    [
                        'text' => '/həˈloʊ/',
                        'audio' => '',
                    ],
                ],
                'meanings' => [
                    [
                        'partOfSpeech' => 'noun',
                        'definitions' => [
                            [
                                'definition' => '"Hello!" or an equivalent greeting.',
                                'synonyms' => [
                                ],
                                'antonyms' => [
                                ],
                            ],
                        ],
                        'synonyms' => [
                            'greeting',
                        ],
                        'antonyms' => [
                        ],
                    ],
                    [
                        'partOfSpeech' => 'verb',
                        'definitions' => [
                            [
                                'definition' => 'To greet with "hello".',
                                'synonyms' => [
                                ],
                                'antonyms' => [
                                ],
                            ],
                        ],
                        'synonyms' => [
                        ],
                        'antonyms' => [
                        ],
                    ],
                    [
                        'partOfSpeech' => 'interjection',
                        'definitions' => [
                            [
                                'definition' => 'A greeting (salutation) said when meeting someone or acknowledging someone’s arrival or presence.',
                                'synonyms' => [
                                ],
                                'antonyms' => [
                                ],
                                'example' => 'Hello, everyone.',
                            ],
                            [
                                'definition' => 'A greeting used when answering the telephone.',
                                'synonyms' => [
                                ],
                                'antonyms' => [
                                ],
                                'example' => 'Hello? How may I help you?',
                            ],
                            [
                                'definition' => 'A call for response if it is not clear if anyone is present or listening, or if a telephone conversation may have been disconnected.',
                                'synonyms' => [
                                ],
                                'antonyms' => [
                                ],
                                'example' => 'Hello? Is anyone there?',
                            ],
                            [
                                'definition' => 'Used sarcastically to imply that the person addressed or referred to has done something the speaker or writer considers to be foolish.',
                                'synonyms' => [
                                ],
                                'antonyms' => [
                                ],
                                'example' => 'You just tried to start your car with your cell phone. Hello?',
                            ],
                            [
                                'definition' => 'An expression of puzzlement or discovery.',
                                'synonyms' => [
                                ],
                                'antonyms' => [
                                ],
                                'example' => 'Hello! What’s going on here?',
                            ],
                        ],
                        'synonyms' => [
                        ],
                        'antonyms' => [
                            'bye',
                            'goodbye',
                        ],
                    ],
                ],
                'license' => [
                    'name' => 'CC BY-SA 3.0',
                    'url' => 'https://creativecommons.org/licenses/by-sa/3.0',
                ],
                'sourceUrls' => [
                    'https://en.wiktionary.org/wiki/hello',
                ],
            ],
        ];

        Http::fake([
            $url => Http::response($response, Response::HTTP_OK),

        ]);
        $freeDictionaryApi = new FreeDictionaryApi();
        $word = 'hello';
        $definitionCollection = $freeDictionaryApi->getDefinitions($word);
        $definitionsArray = [
            new Definition(WordClassEnum::NOUN, '"Hello!" or an equivalent greeting.', $word),
            new Definition(WordClassEnum::VERB, 'To greet with "hello".', $word),
            new Definition(WordClassEnum::INTERJECTION, 'A greeting (salutation) said when meeting someone or acknowledging someone’s arrival or presence.', $word),
            new Definition(WordClassEnum::INTERJECTION, 'A greeting used when answering the telephone.', $word),
            new Definition(WordClassEnum::INTERJECTION, 'A call for response if it is not clear if anyone is present or listening, or if a telephone conversation may have been disconnected.', $word),
            new Definition(WordClassEnum::INTERJECTION, 'Used sarcastically to imply that the person addressed or referred to has done something the speaker or writer considers to be foolish.', $word),
            new Definition(WordClassEnum::INTERJECTION, 'An expression of puzzlement or discovery.', $word),
        ];
        $this->assertEqualsCanonicalizing($definitionsArray, $definitionCollection->toArray());
    }

    public function test_mapper_throws_exception_when_invalid_word_class_has_been_found(): void
    {
        $freeDictionaryApi = new FreeDictionaryApi();
        $this->expectException(InvalidWordClassFoundException::class);
        $freeDictionaryApi->wordClassMapper('SOMETHING_ELSE');

    }
}
