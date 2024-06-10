<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class NotADtoException extends Exception
{
    public function __construct(mixed $nonDto)
    {
        parent::__construct(
            sprintf('Non Dto Item %s found.', get_class($nonDto))
        );
    }
}
