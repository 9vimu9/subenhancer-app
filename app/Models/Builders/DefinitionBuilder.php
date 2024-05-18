<?php

declare(strict_types=1);

namespace App\Models\Builders;

use App\DataObjects\Definitions\Definition;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class DefinitionBuilder extends Builder
{
    public function createByDefinition(int $corpusId, Definition $definition): Model
    {
        return $this->create([
            'corpus_id' => $corpusId,
            'definition' => $definition->getDefinition(),
            'word_class' => $definition->getWordClass()->name,
        ]);
    }
}
