<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Apis\DefinitionsAPI\WikiDataDefinitionsApi;
use App\DataObjects\Definitions\Definition;
use App\DataObjects\Definitions\DefinitionCollection;
use App\Enums\WordClassEnum;
use App\Exceptions\CantFindDefinitionException;
use App\Exceptions\DefinitionsApiErrorException;
use App\Exceptions\InvalidDefinitionResponseFormatException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class WikiDataDefinitionApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_free_dictionary_api_get_definition_method(): void
    {
        $word = 'hello';
        $url = config('app.definition_apis.wikitionary_endpoint').'/*';
        $response = [
            'en' => [
                [
                    'partOfSpeech' => 'Interjection',
                    'language' => 'English',
                    'definitions' => [
                        [
                            'definition' => '<span class="use-with-mention" about="#mwt76" typeof="mw:Transclusion"><span class="Latn" lang="en">A <a rel="mw:WikiLink" href="/wiki/greeting#English" title="greeting">greeting</a> (<a rel="mw:WikiLink" href="/wiki/salutation#English" title="salutation">salutation</a>) said when <a rel="mw:WikiLink" href="/wiki/meet#English" title="meet">meeting</a> someone or <a rel="mw:WikiLink" href="/wiki/acknowledge#English" title="acknowledge">acknowledging</a> someone’s <a rel="mw:WikiLink" href="/wiki/arrival#English" title="arrival">arrival</a> or <a rel="mw:WikiLink" href="/wiki/presence#English" title="presence">presence</a>.</span></span>',
                            'parsedExamples' => [
                                [
                                    'example' => '<b>Hello</b>, everyone.',
                                ],
                            ],
                            'examples' => [
                                '<b>Hello</b>, everyone.',
                            ],
                        ],
                        [
                            'definition' => '<span class="use-with-mention" about="#mwt78" typeof="mw:Transclusion"><span class="Latn" lang="en">A greeting used when <a rel="mw:WikiLink" href="/wiki/answer#English" title="answer">answering</a> the <a rel="mw:WikiLink" href="/wiki/telephone#English" title="telephone">telephone</a>.</span></span>',
                            'parsedExamples' => [
                                [
                                    'example' => '<b>Hello</b><span typeof="mw:Entity">?</span> How may I help you<span typeof="mw:Entity">?</span>',
                                ],
                            ],
                            'examples' => [
                                '<b>Hello</b><span typeof="mw:Entity">?</span> How may I help you<span typeof="mw:Entity">?</span>',
                            ],
                        ],
                        [
                            'definition' => '<span class="use-with-mention" about="#mwt83" typeof="mw:Transclusion"><span class="Latn" lang="en">A call for <a rel="mw:WikiLink" href="/wiki/response#English" title="response">response</a> if it is not clear if anyone is present or listening, or if a telephone conversation may have been <a rel="mw:WikiLink" href="/wiki/disconnect#English" title="disconnect">disconnected</a>.</span></span>',
                            'parsedExamples' => [

                                [
                                    'example' => '<b>Hello</b><span typeof="mw:Entity">?</span> Is anyone there<span typeof="mw:Entity">?</span>',
                                ],
                            ],
                            'examples' => [
                                '<b>Hello</b><span typeof="mw:Entity">?</span> Is anyone there<span typeof="mw:Entity">?</span>',
                            ],
                        ],
                        [
                            'definition' => '<span class="usage-label-sense" about="#mwt86" typeof="mw:Transclusion"></span> <span class="use-with-mention" about="#mwt87" typeof="mw:Transclusion"><span class="Latn" lang="en">Used <a rel="mw:WikiLink" href="/wiki/sarcastic#English" title="sarcastic">sarcastically</a> to imply that the person addressed has done something the speaker considers to be <a rel="mw:WikiLink" href="/wiki/foolish#English" title="foolish">foolish</a>, or missed something that should have been <a rel="mw:WikiLink" href="/wiki/obvious#English" title="obvious">obvious</a>.</span></span>',
                            'parsedExamples' => [
                                [
                                    'example' => 'You just tried to start your car with your cell phone. <b>Hello</b><span typeof="mw:Entity">?</span>',
                                ],
                            ],
                            'examples' => [
                                'You just tried to start your car with your cell phone. <b>Hello</b><span typeof="mw:Entity">?</span>',
                            ],
                        ],
                        [
                            'definition' => '<span class="usage-label-sense" about="#mwt89" typeof="mw:Transclusion"></span> <span class="use-with-mention" about="#mwt90" typeof="mw:Transclusion"><span class="Latn" lang="en">An expression of <a rel="mw:WikiLink" href="/wiki/puzzlement#English" title="puzzlement">puzzlement</a> or <a rel="mw:WikiLink" href="/wiki/discovery#English" title="discovery">discovery</a>.</span></span>',
                            'parsedExamples' => [
                                [
                                    'example' => '<b>Hello</b><span typeof="mw:Entity">!</span> What’s going on here<span typeof="mw:Entity">?</span>',
                                ],
                            ],
                            'examples' => [
                                '<b>Hello</b><span typeof="mw:Entity">!</span> What’s going on here<span typeof="mw:Entity">?</span>',
                            ],
                        ],
                    ],
                ],
                [
                    'partOfSpeech' => 'Noun',
                    'language' => 'English',
                    'definitions' => [
                        [
                            'definition' => '"<a rel="mw:WikiLink" href="/wiki/hello#Interjection" class="mw-selflink-fragment">Hello</a>!" or an equivalent greeting.',
                        ],
                    ],
                ],
                [
                    'partOfSpeech' => 'Verb',
                    'language' => 'English',
                    'definitions' => [
                        [
                            'definition' => '<span class="usage-label-sense" about="#mwt165" typeof="mw:Transclusion"></span> To <a rel="mw:WikiLink" href="/wiki/greet" title="greet">greet</a> with "hello".',
                        ],
                    ],
                ],
            ],
            'fr' => [
                [
                    'partOfSpeech' => 'Interjection',
                    'language' => 'French',
                    'definitions' => [
                        [
                            'definition' => '<span class="usage-label-sense" about="#mwt176" typeof="mw:Transclusion"></span> <span class="Latn" lang="en" about="#mwt177" typeof="mw:Transclusion"><a rel="mw:WikiLink" href="/wiki/hello#English" class="mw-selflink-fragment">hello</a></span>, <a rel="mw:WikiLink" href="/wiki/hi" title="hi">hi</a>',
                        ],
                    ],
                ],
            ],
            'ff' => [
                [
                    'partOfSpeech' => 'Noun',
                    'language' => 'Fula',
                    'definitions' => [
                        [
                            'definition' => 'a <a rel="mw:WikiLink" href="/wiki/page" title="page">page</a>',
                        ],
                        [
                            'definition' => 'one side of a <a rel="mw:WikiLink" href="/wiki/wall" title="wall">wall</a>, a wall',
                        ],
                        [
                            'definition' => 'a <a rel="mw:WikiLink" href="/wiki/slap" title="slap">slap</a> in the face',
                        ],
                    ],
                ],
            ]];

        Http::fake([
            $url => Http::response($response, Response::HTTP_OK),

        ]);
        $actual = (new WikiDataDefinitionsApi())->getDefinitions($word);
        $expected = new DefinitionCollection(
            new Definition(WordClassEnum::INTERJECTION, 'A greeting (salutation) said when meeting someone or acknowledging someone’s arrival or presence.', $word),
            new Definition(WordClassEnum::INTERJECTION, 'A greeting used when answering the telephone.', $word),
            new Definition(WordClassEnum::INTERJECTION, 'A call for response if it is not clear if anyone is present or listening, or if a telephone conversation may have been disconnected.', $word),
            new Definition(WordClassEnum::INTERJECTION, 'Used sarcastically to imply that the person addressed has done something the speaker considers to be foolish, or missed something that should have been obvious.', $word),
            new Definition(WordClassEnum::INTERJECTION, 'An expression of puzzlement or discovery.', $word),
            new Definition(WordClassEnum::NOUN, '"Hello!" or an equivalent greeting.', $word),
            new Definition(WordClassEnum::VERB, 'To greet with "hello".', $word),
        );
        $this->assertEquals($expected, $actual);
    }

    public function test_throws_exception_when_meanings_cannot_be_found(): void
    {
        $word = 'RANDOM';
        $url = config('app.definition_apis.wikitionary_endpoint').'/*';
        Http::fake([
            $url => Http::response(null, Response::HTTP_NOT_FOUND),
        ]);
        $this->expectException(CantFindDefinitionException::class);
        (new WikiDataDefinitionsApi())->getDefinitions($word);

    }

    public function test_throws_exception_when_definition_api_not_functional(): void
    {
        $word = 'RANDOM';
        $url = config('app.definition_apis.wikitionary_endpoint').'/*';
        Http::fake([
            $url => Http::response(null, Response::HTTP_INTERNAL_SERVER_ERROR),
        ]);
        $this->expectException(DefinitionsApiErrorException::class);
        (new WikiDataDefinitionsApi())->getDefinitions($word);

    }

    public function test_throw_exception_when_no_definitions_available(): void
    {
        $invalidResponse =
            [
                'en' => [
                    [
                        'partOfSpeech' => 'Interjection',
                        'language' => 'English',
                        'definitions' => [],
                    ],
                ],
            ];
        $word = 'RANDOM';
        $url = config('app.definition_apis.wikitionary_endpoint').'/*';
        Http::fake([
            $url => Http::response($invalidResponse, Response::HTTP_OK),
        ]);
        $this->expectException(CantFindDefinitionException::class);
        (new WikiDataDefinitionsApi())->getDefinitions($word);
    }

    public function test_throw_exception_when_no_english_key_available(): void
    {
        $invalidResponse =
            [
                'fr' => [
                    [
                        'partOfSpeech' => 'Interjection',
                        'language' => 'French',
                        'definitions' => [
                            [
                                'definition' => '<span class="usage-label-sense" about="#mwt176" typeof="mw:Transclusion"></span> <span class="Latn" lang="en" about="#mwt177" typeof="mw:Transclusion"><a rel="mw:WikiLink" href="/wiki/hello#English" class="mw-selflink-fragment">hello</a></span>, <a rel="mw:WikiLink" href="/wiki/hi" title="hi">hi</a>',
                            ],
                        ],
                    ],
                ],
            ];
        $word = 'RANDOM';
        $url = config('app.definition_apis.wikitionary_endpoint').'/*';
        Http::fake([
            $url => Http::response($invalidResponse, Response::HTTP_OK),
        ]);
        $this->expectException(InvalidDefinitionResponseFormatException::class);
        (new WikiDataDefinitionsApi())->getDefinitions($word);
    }

    public function test_ignore_definitions_without_word_class(): void
    {
        $invalidResponse =
            [
                'en' => [
                    [
                        'language' => 'English',
                        'definitions' => [
                            [
                                'definition' => 'RANDOM DEF 1',
                            ],
                        ],
                    ],
                    [
                        'partOfSpeech' => 'Interjection',
                        'language' => 'English',
                        'definitions' => [
                            [
                                'definition' => 'RANDOM DEF 2',
                            ],
                        ],
                    ],
                ],
            ];
        $word = 'RANDOM';
        $url = config('app.definition_apis.wikitionary_endpoint').'/*';
        Http::fake([
            $url => Http::response($invalidResponse, Response::HTTP_OK),
        ]);
        $actual = (new WikiDataDefinitionsApi())->getDefinitions($word);
        $expected = new DefinitionCollection(
            new Definition(WordClassEnum::INTERJECTION, 'RANDOM DEF 2', $word),
        );
        $this->assertEquals($expected, $actual);
    }

    public function test_ignore_definitions_without_definition(): void
    {
        $invalidResponse =
            [
                'en' => [
                    [
                        'partOfSpeech' => 'Interjection',
                        'language' => 'English',
                        'definitions' => [],
                    ],
                    [
                        'partOfSpeech' => 'Interjection',
                        'language' => 'English',
                        'definitions' => [
                            [
                                'definition' => 'RANDOM DEF 2',
                            ],
                        ],
                    ],
                ],
            ];
        $word = 'RANDOM';
        $url = config('app.definition_apis.wikitionary_endpoint').'/*';
        Http::fake([
            $url => Http::response($invalidResponse, Response::HTTP_OK),
        ]);
        $actual = (new WikiDataDefinitionsApi())->getDefinitions($word);
        $expected = new DefinitionCollection(
            new Definition(WordClassEnum::INTERJECTION, 'RANDOM DEF 2', $word),
        );
        $this->assertEquals($expected, $actual);
    }
}
