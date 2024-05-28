<?php

declare(strict_types=1);

namespace App\Apis\DefinitionsAPI;

use App\Core\Contracts\Apis\DefinitionsApiInterface;
use App\DataObjects\Definitions\Definition;
use App\DataObjects\Definitions\DefinitionCollection;
use App\Enums\WordClassEnum;
use App\Exceptions\CantFindDefinitionException;
use App\Exceptions\DefinitionsApiErrorException;
use App\Exceptions\InvalidDefinitionResponseFormatException;
use App\Exceptions\InvalidWordClassFoundException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class WikiDataDefinitionsApi implements DefinitionsApiInterface
{
    public function getDefinitions(string $word): DefinitionCollection
    {
        $response = Http::acceptJson()->withHeaders([
            'charset' => 'utf-8',
            'profile' => 'https://www.mediawiki.org/wiki/Specs/definition/0.8.0"',
        ])->withUrlParameters([
            'endpoint' => config('app.definition_apis.wikitionary_endpoint'),
            'word' => $word,
            'redirection' => 'false',
        ])->get('{+endpoint}/{word}?redirect={redirection}');

        if ($response->status() === Response::HTTP_NOT_FOUND) {
            throw new CantFindDefinitionException();
        }
        if ($response->status() !== Response::HTTP_OK) {
            throw new DefinitionsApiErrorException($response, $word);
        }
        $content = $response->json();

        if (! isset($content['en'])) {
            throw new InvalidDefinitionResponseFormatException('no English definitions were found', $content, $word);
        }
        $definitions = $content['en'];
        $definitionCollection = new DefinitionCollection();
        foreach ($definitions as $definition) {
            if (! isset($definition['partOfSpeech'])) {
                continue;
            }
            try {
                $wordClass = $this->wordClassMapper($definition['partOfSpeech']);
            } catch (InvalidWordClassFoundException $e) {
                continue;
            }

            if (! isset($definition['definitions'])) {
                continue;
            }
            foreach ($definition['definitions'] as $definitionItem) {
                if (! isset($definitionItem['definition'])) {
                    continue;
                }
                $definitionCollection->add(new Definition(
                    $wordClass,
                    trim(strip_tags($definitionItem['definition'])),
                    $word
                ));

            }

        }
        if ($definitionCollection->count() === 0) {
            throw new CantFindDefinitionException();
        }

        return $definitionCollection;
    }

    public function wordClassMapper(string $wordClass): WordClassEnum
    {
        foreach (WordClassEnum::cases() as $class) {
            if ($class->name === Str::upper($wordClass)) {
                return $class;
            }
        }
        throw new InvalidWordClassFoundException;
    }
}
