<?php

declare(strict_types=1);

namespace App\Dtos;

use App\Core\Contracts\Dtos\DtoInterface;
use App\Models\Captionword;
use Illuminate\Database\Eloquent\Model;

class CaptionwordDto implements DtoInterface
{
    public function __construct(
        public ?int $id,
        public ?int $order,
        public ?int $sentenceId,
        public ?int $definitionId
    ) {
    }

    public function toArray(): array
    {
        return
            [
                'id' => $this->id,
                'order_in_sentence' => $this->order,
                'sentence_id' => $this->sentenceId,
                'definition_id' => $this->definitionId,
            ];
    }

    public function load(Captionword|Model $model): DtoInterface
    {
        $this->id = $model->getAttributeOrNull('id');
        $this->order = $model->getAttributeOrNull('order_in_sentence');
        $this->sentenceId = $model->getAttributeOrNull('sentence_id');
        $this->definitionId = $model->getAttributeOrNull('definition_id');

        return $this;
    }
}
