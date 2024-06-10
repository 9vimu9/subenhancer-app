<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Core\Contracts\Dtos\Arrayable;
use Exception;

class NotADtoItemIncludedToTheCollectionException extends Exception
{
    public function __construct(Arrayable $collection, mixed $dto)
    {
        $message = sprintf('Found Non arrayable DTO item %s in the DTO collection %d.', get_class($dto), get_class($collection));
        parent::__construct($message);
    }
}
