<?php

declare(strict_types=1);

namespace App\Services\SrtParser;

use App\DataObjects\Captions\CaptionsCollection;

interface SrtParserInterface
{
    public function parse(string $fileContent): CaptionsCollection;
}
