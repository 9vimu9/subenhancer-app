<?php

declare(strict_types=1);

namespace App\Dtos;

use App\Core\Contracts\Dtos\AbstractDtoCollection;
use App\Core\Contracts\Dtos\DtoInterface;
use IteratorAggregate;

/**
 * @implements IteratorAggregate<int, CaptionwordDto>
 */
class CaptionwordDtoCollection extends AbstractDtoCollection
{
    public function itemDto(): DtoInterface
    {
        return new CaptionwordDto();
    }
}
