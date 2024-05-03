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
        $user = User::query()->where('email', config('app.demo.generic_user_email'))->first();
        $videoURL = 'https://www.youtube.com/watch?v=lRVJuPI5IXI&ab_channel=FujiiKaze';
        $this->browse(function (Browser $browser) use ($user, $videoURL) {
            $browser->loginAs($user)->visitRoute('dashboard')
                ->waitForText('New Enhancement')
                ->type('video_url', $videoURL)
                ->press('start_enhance_btn')
                ->assertSee('YouTube video has been added successfully for the enhancement. You will receive a notification shortly');
        });
    }

    public function testNewEnhancementSubmissionWithUnsupportedURL(): void
    {
        $user = User::query()->where('email', config('app.demo.generic_user_email'))->first();
        $videoURL = 'unsupported-url';
        $this->browse(function (Browser $browser) use ($user, $videoURL) {
            $browser->loginAs($user)->visitRoute('dashboard')
                ->waitForText('New Enhancement')
                ->type('video_url', $videoURL)
                ->press('start_enhance_btn')
                ->assertSee('YouTube URL is not valid.');
        });
    }

    public function testNewEnhancementWithSrtFile(): void
    {
        $user = User::query()->where('email', config('app.demo.generic_user_email'))->first();
        $filePath = __DIR__.'/Inputs/srt_file.srt';
        $this->browse(function (Browser $browser) use ($user, $filePath) {
            $browser->loginAs($user)->visitRoute('dashboard')
                ->waitForText('New Enhancement')
                ->attach('subtitle_file', $filePath)
                ->press('start_enhance_btn')
                ->assertSee('File has been added successfully for the enhancement. You will receive a notification shortly');
        });
    }

    public function testNewEnhancementWithUnsupportedFile(): void
    {
        $user = User::query()->where('email', config('app.demo.generic_user_email'))->first();
        $filePath = __DIR__.'/Inputs/unsupported_file.xyz';
        $this->browse(function (Browser $browser) use ($user, $filePath) {
            $browser->loginAs($user)->visitRoute('dashboard')
                ->waitForText('New Enhancement')
                ->attach('subtitle_file', $filePath)
                ->press('start_enhance_btn')
                ->assertSee('The subtitle file field must be a file of type: application/x-subrip.');
        });
    }

    public function testWhenBothFieldsAreNotEmpty(): void
    {
        $user = User::query()->where('email', config('app.demo.generic_user_email'))->first();
        $filePath = __DIR__.'/Inputs/srt_file.srt';
        $videoURL = 'https://www.youtube.com/watch?v=lRVJuPI5IXI&ab_channel=FujiiKaze';
        $this->browse(function (Browser $browser) use ($user, $filePath, $videoURL) {
            $browser->loginAs($user)->visitRoute('dashboard')
                ->waitForText('New Enhancement')
                ->attach('subtitle_file', $filePath)
                ->type('video_url', $videoURL)
                ->press('start_enhance_btn')
                ->assertSee('The subtitle file field is prohibited unless video url is in null.')
                ->assertSee('The video url field is prohibited unless subtitle file is in null.');
        });
    }
}
