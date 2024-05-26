<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Apis\YoutubeCaptionsGrabberApi\MockYoutubeCaptionsGrabberApi;
use Error;
use Tests\TestCase;

class MockYoutubeCaptionsGrabberApiTest extends TestCase
{
    public function test_getCaptions(): void
    {
        $captions = (new MockYoutubeCaptionsGrabberApi())
            ->getCaptions('Nb1PrONDHhk');
        $captionsArray = json_decode($captions, true);
        $this->assertArrayNotHasKey('transcript', $captionsArray);
    }

    public function test_throws_error_when_id_is_not_available(): void
    {
        $this->expectException(Error::class)(new MockYoutubeCaptionsGrabberApi())->getCaptions('RANDOM_ID');
    }
}
