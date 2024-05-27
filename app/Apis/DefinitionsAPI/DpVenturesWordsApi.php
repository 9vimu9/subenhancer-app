<?php

declare(strict_types=1);

namespace App\Apis\DefinitionsAPI;

use App\Core\Contracts\Apis\DefinitionsApiInterface;
use App\DataObjects\Definitions\Definition;
use App\DataObjects\Definitions\DefinitionCollection;
use App\Enums\WordClassEnum;
use App\Exceptions\CantFindDefinitionException;
use App\Exceptions\DefinitionsApiErrorException;
use App\Exceptions\InvalidWordClassFoundException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class DpVenturesWordsApi implements DefinitionsApiInterface
{
    public function getDefinitions(string $word): DefinitionCollection
    {
        $url = config('app.definition_apis.dp_ventures.endpoint').$word.'/definitions';
        $response = Http::withHeaders([
            'X-RapidAPI-Host' => config('app.definition_apis.dp_ventures.host'),
            'X-RapidAPI-Key' => config('app.definition_apis.dp_ventures.api_key'),
        ])->get($url);
        if ($response->status() === Response::HTTP_NOT_FOUND) {
            throw new CantFindDefinitionException();
        }
        if ($response->status() !== Response::HTTP_OK) {
            throw new DefinitionsApiErrorException($response, $word);
        }

        $definitionCollection = new DefinitionCollection();
        foreach ($response->json()['definitions'] as $definition) {
            $wordClass = $this->wordClassMapper($definition['partOfSpeech']);
            $definitionCollection->add(new Definition($wordClass, $definition['definition'], $word));
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
