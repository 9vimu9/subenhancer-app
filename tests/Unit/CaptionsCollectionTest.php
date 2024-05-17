<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\DataObjects\Captions\Caption;
use App\DataObjects\Captions\CaptionsCollection;
use PHPUnit\Framework\TestCase;

class CaptionsCollectionTest extends TestCase
{
    public function test_tostring_method(): void
    {
        $capOneCaption = 'Caption 1';
        $capTwoCaption = 'Caption 2';
        $captionString = $capOneCaption.' '.$capTwoCaption;
        $capOne = new Caption();
        $capOne->setCaption($capOneCaption);
        $capTwo = new Caption();
        $capTwo->setCaption($capTwoCaption);
        $captionsCollection = new CaptionsCollection($capOne, $capTwo);
        $this->assertEquals($captionString, $captionsCollection->tostring());

    }
}
