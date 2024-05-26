<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Client\Response;

class DefinitionsApiErrorException extends Exception
{
    public function __construct(Response $response, string $word)
    {
        $message = 'WORD :"'.$word.'"  REASON :"'.$response->getReasonPhrase().'"  STATUS :'.$response->status();
        parent::__construct($message);
    }
}
