<?php

declare(strict_types=1);

namespace App\Dtos;

use App\Core\Contracts\Dtos\DtoInterface;
use App\Models\Duration;
use Illuminate\Database\Eloquent\Model;

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

    public function load(Duration|Model $duration): DurationDto
    {
        $this->id = $duration->getAttributeOrNull('id');
        $this->endTime = $duration->getAttributeOrNull('end_time_in_millis');
        $this->startTime = $duration->getAttributeOrNull('start_time_in_millis');
        $this->sourceId = $duration->getAttributeOrNull('source_id');

        return $this;
    }
}
