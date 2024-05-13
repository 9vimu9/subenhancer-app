<?php

declare(strict_types=1);

namespace App\Services\Captions;

class CaptionsCollection
{
    /**
     * @template T of Caption
     *
     * @var array<int, T>
     */
    private array $captions = [];

    public function addCaption(Caption $caption): void
    {
        $this->captions[] = $caption;
    }

    /**
     * @template T of Caption
     *
     * @return array<int, T>
     */
    public function captions(): array
    {
        return $this->captions;
    }

    public function toString(): string
    {
        $captionsStrings = '';
        foreach ($this->captions as $caption) {
            $captionsStrings .= $caption->getCaption();
        }

        return $captionsStrings;
    }
}
