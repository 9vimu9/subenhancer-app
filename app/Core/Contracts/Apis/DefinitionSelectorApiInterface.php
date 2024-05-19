<?php

declare(strict_types=1);

namespace App\Core\Contracts\Apis;

interface DefinitionSelectorApiInterface
{
    public function pickADefinitionBasedOnContext(string $context, array $definitionArray, string $word, int $orderInTheContext): string;
}
