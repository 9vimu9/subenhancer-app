<?php

declare(strict_types=1);

namespace App\Services\DefinitionsAPI;

use App\DataObjects\Definitions\DefinitionCollection;
use App\Enums\WordClassEnum;

interface DefinitionsApiInterface
{
    public function getDefinitions(string $word): DefinitionCollection;

    public function wordClassMapper(string $wordClass): WordClassEnum;
}
