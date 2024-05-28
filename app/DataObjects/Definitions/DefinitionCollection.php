<?php

declare(strict_types=1);

namespace App\DataObjects\Definitions;

use App\Core\Contracts\DataObjects\AbstractCollection;
use App\Enums\WordClassEnum;
use App\Models\Corpus;
use IteratorAggregate;

/**
 * @implements IteratorAggregate<int, Definition>
 */
class DefinitionCollection extends AbstractCollection
{
    public function loadByWord(string $word): bool
    {
        $corpus = Corpus::query()->findByWord($word);
        if (is_null($corpus)) {
            return false;
        }
        if (is_null($definitions = $corpus->definitions()->get())) {
            return false;
        }
        foreach ($definitions as $definition) {
            $this->add(
                new Definition(
                    WordClassEnum::fromName($definition->word_class),
                    $definition->definition,
                    $word
                )
            );
        }

        return true;

    }
}
