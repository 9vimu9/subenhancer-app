<?php

declare(strict_types=1);

namespace App\Traits;

trait StringArrayOperationsTrait
{
    public function stringToCleansedWordArray(string $text): array
    {
        return [];

    }

    public function getIntersectionOfWordArrays(array $arrayOne, array $arrayTwo): array
    {
        return array_intersect($arrayOne, $arrayTwo);
    }
}
