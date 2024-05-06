<?php

declare(strict_types=1);

namespace App\Services\Definitions;

class DefinitionCollection
{
    private array $definitions = [];

    public function addDefinition(Definition $definition): void
    {
        $this->definitions[] = $definition;
    }

    public function toArray(): array
    {
        return $this->definitions;
    }
}
