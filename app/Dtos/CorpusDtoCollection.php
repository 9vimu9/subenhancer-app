<?php

declare(strict_types=1);

namespace App\Dtos;

use App\Core\Contracts\Dtos\AbstractDtoCollection;
use IteratorAggregate;

/**
 * @implements IteratorAggregate<int, CorpusDto>
 */
class CorpusDtoCollection extends AbstractDtoCollection
{
}