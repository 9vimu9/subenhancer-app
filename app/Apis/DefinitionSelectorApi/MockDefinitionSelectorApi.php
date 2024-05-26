<?php

declare(strict_types=1);

namespace App\Apis\DefinitionSelectorApi;

use App\Core\Contracts\Apis\DefinitionSelectorApiInterface;

class MockDefinitionSelectorApi implements DefinitionSelectorApiInterface
{
    public function pickADefinitionBasedOnContext(string $context, array $definitionArray, string $word, int $orderInTheContext): string
    {
        return $definitionArray[array_rand($definitionArray)];
    }
}
