<?php

declare(strict_types=1);

namespace Tests\Helpers;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Event;

class DatabaseHelper
{
    public static function logQueriesToConsole(): void
    {
        Event::listen(QueryExecuted::class, static function ($query) {
            error_log(str_replace('\"', '"', json_encode([
                'query' => $query->sql,
                'bindings' => $query->bindings,
                'time' => $query->time.'ms',
            ])));
        });
    }
}
