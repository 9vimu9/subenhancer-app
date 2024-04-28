<?php

declare(strict_types=1);

namespace Tests\Browser;

use App\Models\User;
use App\Traits\Testing\DatabaseMigrationsAndSeeders;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SubmitEnhancementTest extends DuskTestCase
{
    use DatabaseMigrationsAndSeeders;

    public function testNewEnhancementSubmissionWithYouTubeURL(): void
    {
        $user = User::query()->where('email', env('GENERIC_USER_EMAIL'))->first();
        $videoURL = 'https://www.youtube.com/watch?v=lRVJuPI5IXI&ab_channel=FujiiKaze';
        $this->browse(function (Browser $browser) use ($user, $videoURL) {

            $browser->loginAs($user)->visitRoute('dashboard')
                ->waitForText('New Enhancement')
                ->type('video_url', $videoURL)
                ->press('start_enhance_btn')
                ->assertRouteIs('dashboard');
        });
    }
}
