<?php

declare(strict_types=1);

namespace Tests\Mocks;

use App\Core\Contracts\Apis\DefinitionsApiInterface;
use App\DataObjects\Definitions\Definition;
use App\DataObjects\Definitions\DefinitionCollection;
use App\Enums\WordClassEnum;
use App\Exceptions\CantFindDefinitionException;

class MockDefinitionsApi implements DefinitionsApiInterface
{
    public const string DEFINITION = '"Hello!" or an equivalent greeting.';

    public const WordClassEnum WORD_CLASS = WordClassEnum::NOUN;

    public function getDefinitions(string $word): DefinitionCollection
    {
        if ($word === 'NO_DEFINITION_AVAILABLE') {
            throw new CantFindDefinitionException();
        }
        $collection = new DefinitionCollection();
        $collection->add(new Definition(WordClassEnum::NOUN, '"Hello!" or an equivalent greeting.', $word));

        return $collection;
    }

    public function wordClassMapper(string $wordClass): WordClassEnum
    {
        return WordClassEnum::NOUN;
    }
}
