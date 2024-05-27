<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class InvalidDefinitionResponseFormatException extends Exception
{
    public function __construct(string $message, array $content, string $word)
    {
        $message = "Invalid Definition Response for word: $word message:$message content:".json_encode($content);
        parent::__construct($message);
    }
}
