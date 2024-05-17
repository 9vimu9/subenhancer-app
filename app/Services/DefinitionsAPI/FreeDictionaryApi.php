<?php

declare(strict_types=1);

namespace App\Services\DefinitionsAPI;

use App\DataObjects\Definitions\Definition;
use App\DataObjects\Definitions\DefinitionCollection;
use App\Enums\WordClassEnum;
use App\Exceptions\CantFindDefinitionException;
use App\Exceptions\DefinitionsApiErrorException;
use App\Exceptions\InvalidWordClassFoundException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class FreeDictionaryApi implements DefinitionsApiInterface
{
    public function getDefinitions(string $word): DefinitionCollection
    {
        $url = config('app.definition_apis.free_dictionary_api').$word;
        $response = Http::get($url);
        if ($response->status() === Response::HTTP_NOT_FOUND) {
            throw new CantFindDefinitionException();
        }
        if ($response->status() !== Response::HTTP_OK) {
            throw new DefinitionsApiErrorException();
        }
        $definitionCollection = new DefinitionCollection();
        foreach ($response->json()[0]['meanings'] as $meaning) {
            $wordClass = $this->wordClassMapper($meaning['partOfSpeech']);
            foreach ($meaning['definitions'] as $definition) {
                $definitionCollection->add(new Definition($wordClass, $definition['definition'], $word));
            }

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
