<?php

declare(strict_types=1);

namespace App\Traits\Testing;

use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

trait DatabaseMigrationsAndSeeders
{
    use DatabaseMigrations {
        DatabaseMigrations::runDatabaseMigrations as _runDatabaseMigrations;
    }
    use InteractsWithDatabase;

    public function runDatabaseMigrations(): void
    {
        $this->_runDatabaseMigrations();
        $this->seed();
    }
}
