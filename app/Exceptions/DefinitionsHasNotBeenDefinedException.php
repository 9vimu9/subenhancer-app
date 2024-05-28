<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class DefinitionsHasNotBeenDefinedException extends Exception
{
    public function __construct(string $word)
    {
        parent::__construct(
            sprintf('Definitions has not been assigned to the filtered word "%s"', $word)
        );
    }
}
