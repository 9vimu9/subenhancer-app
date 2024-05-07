<?php

declare(strict_types=1);

namespace Tests\Mocks;

use App\Enums\WordClassEnum;
use App\Exceptions\CantFindDefinitionException;
use App\Services\Definitions\Definition;
use App\Services\Definitions\DefinitionCollection;
use App\Services\DefinitionsAPI\DefinitionsApiInterface;

class MockDefinitionsApi implements DefinitionsApiInterface
{
    public function getDefinitions(string $word): DefinitionCollection
    {
        if ($word === 'NO_DEFINITION_AVAILABLE') {
            throw new CantFindDefinitionException();
        }
        $collection = new DefinitionCollection();
        $collection->addDefinition(new Definition(WordClassEnum::NOUN, '"Hello!" or an equivalent greeting.', $word));

        return $collection;
    }

    public function wordClassMapper(string $wordClass): WordClassEnum
    {
        return WordClassEnum::NOUN;
    }
}
