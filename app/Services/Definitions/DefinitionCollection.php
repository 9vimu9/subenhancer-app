<?php

declare(strict_types=1);

namespace App\Services\Definitions;

class DefinitionCollection
{
    /**
     * @template T of Definition
     *
     * @var array<int, T>
     */
    private array $definitions = [];

    public function addDefinition(Definition $definition): void
    {
        $this->definitions[] = $definition;
    }

    /**
     * @template T of Definition
     *
     * @return array<int, T>
     */
    public function toArray(): array
    {
        return $this->definitions;
    }
}
