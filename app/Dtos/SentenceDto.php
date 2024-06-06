<?php

declare(strict_types=1);

namespace App\Dtos;

use App\Core\Contracts\Dtos\DtoInterface;
use App\Models\Sentence;
use Illuminate\Database\Eloquent\Model;

class SentenceDto implements DtoInterface
{
    public function __construct(
        public ?int $id,
        public ?int $order,
        public ?string $sentence,
        public ?int $durationId
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'order' => $this->order,
            'sentence' => $this->sentence,
            'duration_id' => $this->durationId,
        ];
    }

    public function load(Sentence|Model $model): DtoInterface
    {
        $this->id = $model->getAttributeOrNull('id');
        $this->order = $model->getAttributeOrNull('order');
        $this->sentence = $model->getAttributeOrNull('sentence');
        $this->durationId = $model->getAttributeOrNull('duration_id');
    }
}
