<?php

declare(strict_types=1);

namespace App\Core\Contracts\Dtos;

interface DtoCollectionInterface extends ArrayableInterface, LoadByCollectionInterface
{
    public function itemDto(): DtoInterface;
}
