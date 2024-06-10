<?php

declare(strict_types=1);

namespace App\Dtos;

use App\Core\Contracts\Dtos\AbstractDtoCollection;
use IteratorAggregate;

/**
 * @implements IteratorAggregate<int, DefinitionDto>
 */
class DefinitionDtoCollection extends AbstractDtoCollection
{
    public function definitionsArrray(): array
    {
        return array_map(static fn (DefinitionDto $dto) => $dto->definition, $this->items);
    }

    public function findDefinitionDtoByDefinition(string $definition): DefinitionDto
    {
        foreach ($this->items as $dto) {
            if ($dto->definition === $definition) {
                return $dto;
            }
        }
        throw new \InvalidArgumentException();
    }
}
