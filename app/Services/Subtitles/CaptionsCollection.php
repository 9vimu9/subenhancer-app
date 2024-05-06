<?php

declare(strict_types=1);

namespace App\Services\Subtitles;

class CaptionsCollection
{
    private array $captions = [];

    public function addCaption(Caption $caption): void
    {
        $this->captions[] = $caption;
    }

    public function captions(): array
    {
        return $this->captions;
    }
}
