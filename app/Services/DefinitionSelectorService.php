<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Contracts\Apis\DefinitionSelectorApiInterface;
use App\Core\Contracts\Services\DefinitionSelectorServiceInterface;
use App\DataObjects\Sentences\Sentence;

class DefinitionSelectorService implements DefinitionSelectorServiceInterface
{
    public function __construct(private DefinitionSelectorApiInterface $definitionSelectorApi)
    {
    }

    public function findMostSuitableDefinitionId(
        Sentence $sentence,
        array $word,
        int $orderInTheSentence): ?int
    {
        $definitions = $word['definitions'];
        if (count($definitions) === 0) {
            return null;
        }

        $definitionArray = array_column($definitions, 'definition');
        $definition = count($definitions) === 1
            ? array_values($definitions)[0]['definition']
            : $this->definitionSelectorApi->pickADefinitionBasedOnContext(
                $sentence->getSentence(),
                $definitionArray,
                $word['word'], $orderInTheSentence);

        return $definitions[(array_search($definition, $definitionArray, true))]['id'];
    }
}
