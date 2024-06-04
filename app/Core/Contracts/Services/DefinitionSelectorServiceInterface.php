<?php

declare(strict_types=1);

namespace App\Core\Contracts\Services;

use App\DataObjects\Sentences\Sentence;
use App\Dtos\CorpusDto;

interface DefinitionSelectorServiceInterface
{
    public function findMostSuitableDefinitionId(
        Sentence $sentence,
        CorpusDto $corpusDto,
        int $orderInTheSentence): ?int;
}
