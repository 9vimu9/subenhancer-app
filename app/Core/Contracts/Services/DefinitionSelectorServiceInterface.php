<?php

declare(strict_types=1);

namespace App\Core\Contracts\Services;

use App\DataObjects\Sentences\Sentence;

interface DefinitionSelectorServiceInterface
{
    public function findMostSuitableDefinitionId(
        Sentence $sentence,
        array $word,
        int $orderInTheSentence): ?int;
}
