<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class YouTubeURLRule implements ValidationRule
{
    const REG_EX = '/^((?:https?:)?\/\/)?((?:www|m)\.)?(youtube\.com|youtu.be)(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$/';

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! preg_match(self::REG_EX, $value)) {
            $fail('YouTube URL is not valid.');
        }
    }
}
