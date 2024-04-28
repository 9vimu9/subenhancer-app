<?php

declare(strict_types=1);

namespace Tests\Browser;

use App\Traits\Testing\DatabaseMigrationsAndSeeders;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ExampleTest extends DuskTestCase
{
    use DatabaseMigrationsAndSeeders;

    /**
     * A basic browser test example.
     */
    public function testBasicExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Home Page');
        });
    }
}
