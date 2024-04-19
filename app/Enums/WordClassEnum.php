<?php

declare(strict_types=1);

namespace App\Enums;

enum WordClassEnum: int
{
    case NOUN = 1;
    case VERB = 2;
    case ADJECTIVE = 3;
    case ADVERB = 4;
    case PREPOSITION = 5;
    case DETERMINER = 6;
    case PRONOUN = 7;
    case CONJUNCTION = 8;
    case INTERJECTION = 9;

}
