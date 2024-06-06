<?php

declare(strict_types=1);

namespace App\Core\Database;

use Illuminate\Database\Eloquent\Builder;

class CustomBuilder extends Builder
{
    public function insertOrIgnore(array $records): int
    {
        if (! is_array(reset($records))) {
            return parent::insertOrIgnore($records);
        }

        return parent::insertOrIgnore(
            array_map(static fn ($record) => array_filter($record, static fn ($value) => $value !== null), $records)
        );
    }
}
