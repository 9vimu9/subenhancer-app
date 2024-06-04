<?php

declare(strict_types=1);

namespace App\Dtos;

use App\Core\Contracts\Dtos\AbstractDtoCollection;
use App\Enums\WordClassEnum;
use App\Models\Definition;
use Illuminate\Database\Eloquent\Collection;
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

    public function findDefinitionDtoByDefinition(string $definition): ?DefinitionDto
    {
        foreach ($this->items as $dto) {
            if ($dto->definition === $definition) {
                return $dto;
            }
        }
        throw new \InvalidArgumentException();
    }

    public function loadByDefinitions(Collection $definitions): DefinitionDtoCollection
    {
        $this->items = [];
        $definitions->each(function (Definition $definition) {
            $this->add(
                new DefinitionDto(
                    id: $definition->id,
                    corpusId: $definition->corpus_id,
                    definition: $definition->definition,
                    wordClass: WordClassEnum::fromName($definition->word_class)

                )
            );
        });

        return $this;
    }
}
