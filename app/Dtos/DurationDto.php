<?php

declare(strict_types=1);

namespace App\Dtos;

use App\Core\Contracts\Dtos\DtoInterface;

class DurationDto implements DtoInterface
{
    public function __construct(
        public ?int $id,
        public ?int $startTime,
        public ?int $endTime,
        public ?int $sourceId
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'start_time_in_millis' => $this->startTime,
            'end_time_in_millis' => $this->endTime,
            'source_id' => $this->sourceId,
        ];
    }
}
