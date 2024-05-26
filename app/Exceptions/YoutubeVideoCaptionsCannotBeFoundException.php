<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class YoutubeVideoCaptionsCannotBeFoundException extends Exception
{
    public function __construct(string $videoId)
    {
        parent::__construct("YouTube video id: '$videoId' not found");
    }
}
