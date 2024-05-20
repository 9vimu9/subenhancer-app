<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Contracts\Apis\DefinitionSelectorApiInterface;
use App\Core\Contracts\Services\DefinitionSelectorServiceInterface;
use App\DataObjects\Sentences\Sentence;
use App\Models\Captionword;
use App\Models\Corpus;
use App\Models\Definition;

class DefinitionSelectorService implements DefinitionSelectorServiceInterface
{
    public function __construct(private DefinitionSelectorApiInterface $definitionSelectorApi)
    {
    }

    private function chooseDefinition(Sentence $sentence, int $corpusId, int $orderInTheSentence): Definition
    {
        $definition = $this->definitionSelectorApi
            ->pickADefinitionBasedOnContext(
                $sentence->getSentence(),
                Definition::query()->getCandidateDefinitionsArrayByWordOrFail($corpusId),
                Corpus::query()->findOrFail($corpusId)->getAttribute('word'),
                $orderInTheSentence);

        return Definition::query()->findByDefinitionAndCorpusId($definition, $corpusId);

    }

    public function updateFilteredWordDefinition(
        int $filteredWordId,
        Sentence $sentence,
        int $corpusId,
        int $orderInTheSentence): void
    {
        Captionword::query()->updateDefinition(
            $filteredWordId,
            $this->chooseDefinition($sentence, $corpusId, $orderInTheSentence)->getAttribute('id')
        );
    }
}
