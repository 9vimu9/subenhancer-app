<?php

declare(strict_types=1);

namespace App\Dtos;

use App\Core\Contracts\Dtos\DtoInterface;
use App\Models\Corpus;
use Illuminate\Database\Eloquent\Model;

class CorpusDto implements DtoInterface
{
    public function __construct(
        public ?int $id = null,
        public ?string $word = null,
        public ?DefinitionDtoCollection $definitions = null,
    ) {
    }

    public function toArray(): array
    {
        $data = [
            'word' => $this->word,
            'definitions' => $this->definitions->toArray(),
        ];
        if (! is_null($this->id)) {
            $data['id'] = $this->id;
        }

        return $data;
    }

    public function load(Corpus|Model $model): DtoInterface
    {
        $this->id = $model->getAttributeOrNull('id');
        $this->word = $model->getAttributeOrNull('word');
        $this->definitions = $model->getAttributeOrNull('definitions');

        return $this;
    }
}
