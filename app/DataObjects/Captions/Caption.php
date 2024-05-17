<?php

declare(strict_types=1);

namespace App\DataObjects\Captions;

class Caption
{
    public function __construct(private string $captionString, private int $startTime, private int $endTime)
    {
    }

    public function setCaption(string $captionString): void
    {
        $this->captionString = $captionString;
    }

    public function setStartTime(int $startTime): void
    {
        $this->startTime = $startTime;
    }

    public function setEndTime(int $endTime): void
    {
        $this->endTime = $endTime;
    }

    public function getCaption(): string
    {
        return $this->captionString;
    }

    public function getStartTime(): int
    {
        return $this->startTime;
    }

    public function getEndTime(): int
    {
        return $this->endTime;
    }
}
