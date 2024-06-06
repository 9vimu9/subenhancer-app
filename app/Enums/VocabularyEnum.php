<?php

declare(strict_types=1);

namespace App\Enums;

enum VocabularyEnum: int
{
    case FILTERED_OUT_AS_KNOWN_USING_THE_TEST = 1;
    case MARKED_AS_KNOWN = 2;
    case MARKED_AS_UNKNOWN = 3;
    case HAVE_NOT_SPECIFIED = 4;

    public static function fromName(string $name)
    {
        return constant("self::$name");
    }
}
