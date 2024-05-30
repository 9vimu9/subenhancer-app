<?php

declare(strict_types=1);

namespace App\Core\Database;

use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

trait LastInsertedIdTrait
{
    public function getLastInsertedId(string $tableName)
    {
        $resultSet = DB::select(
            "SELECT `AUTO_INCREMENT`
        FROM  INFORMATION_SCHEMA.TABLES
        WHERE TABLE_SCHEMA = '".DB::getDatabaseName()."'
        AND   TABLE_NAME   = '".$tableName."'
        LIMIT 1;"
        );

        return count($resultSet) > 0 && ! is_null($lastId = $resultSet[0]->AUTO_INCREMENT)
            ? $lastId - 1
            : throw new InvalidArgumentException();
    }
}
