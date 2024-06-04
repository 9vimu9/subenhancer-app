<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Contracts\Apis\DefinitionSelectorApiInterface;
use App\Core\Contracts\Services\DefinitionSelectorServiceInterface;
use App\DataObjects\Sentences\Sentence;
use App\Dtos\CorpusDto;

class DefinitionSelectorService implements DefinitionSelectorServiceInterface
{
    public function __construct(private DefinitionSelectorApiInterface $definitionSelectorApi)
    {
    }

    public function findMostSuitableDefinitionId(
        Sentence $sentence,
        CorpusDto $corpusDto,
        int $orderInTheSentence): ?int
    {
        $definitions = $corpusDto->definitions;
        if ($definitions->count() === 0) {
            return null;
        }

        if ($definitions->count() === 1) {
            return $definitions->get(0);
        }
        $definitionString = $this->definitionSelectorApi->pickADefinitionBasedOnContext(
            $sentence->getSentence(),
            $definitions->definitionsArrray(),
            $corpusDto->word, $orderInTheSentence);

        return $definitions->findDefinitionDtoByDefinition($definitionString)->id;
    }
}
