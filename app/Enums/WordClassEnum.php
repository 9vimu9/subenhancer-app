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
    case ARTICLE = 10;
    case PROPER_NOUN = 11;
    case LETTER = 12;
    case CHARACTER = 13;
    case PHRASE = 14;
    case PROVERB = 15;
    case IDIOM = 16;
    case SYMBOL = 17;
    case SYLLABLE = 18;
    case NUMERAL = 19;
    case INITIALISM = 20;
    case DEFINITIONS = 21;
    case PARTICLE = 22;
    case PREDICATIVE = 23;
    case PARTICIPLE = 24;
    case SUFFIX = 25;

    public static function fromName(string $name)
    {

        return constant("self::$name");
    }
}
