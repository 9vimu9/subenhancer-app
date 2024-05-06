<?php

declare(strict_types=1);

namespace App\Services\DefinitionsAPI;

use App\Enums\WordClassEnum;
use App\Services\Definitions\DefinitionCollection;

interface DefinitionsApiInterface
{
    public function getDefinitions(string $word): DefinitionCollection;

    public function wordClassMapper(string $wordClass): WordClassEnum;
}
