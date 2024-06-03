<?php

declare(strict_types=1);

namespace App\Dtos\Duration;

use App\Core\Contracts\Dtos\AbstractDtoCollection;
use IteratorAggregate;

/**
 * @implements IteratorAggregate<int, DurationDto>
 */
class DurationDtoCollection extends AbstractDtoCollection
{
}
