<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class InvalidYoutubeCaptionException extends Exception
{
    public function __construct(array $caption)
    {
        $message = 'Invalid youtube Caption : '.json_encode($caption, JSON_PRETTY_PRINT);
        parent::__construct($message);
    }
}
