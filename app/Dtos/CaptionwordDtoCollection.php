<?php

declare(strict_types=1);

namespace App\Dtos;

use App\Core\Contracts\Dtos\AbstractDtoCollection;
use App\Models\Captionword;
use Illuminate\Database\Eloquent\Collection;
use IteratorAggregate;

/**
 * @implements IteratorAggregate<int, CaptionwordDto>
 */
class CaptionwordDtoCollection extends AbstractDtoCollection
{
    public function load(Collection $collection): AbstractDtoCollection
    {
        $this->items = [];
        $collection->each(fn (Captionword $captionword) => $this->add((new CaptionwordDto())->load($captionword)));

        return $this;
    }
}
