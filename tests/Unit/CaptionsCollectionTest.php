<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Services\Captions\Caption;
use App\Services\Captions\CaptionsCollection;
use PHPUnit\Framework\TestCase;

class CaptionsCollectionTest extends TestCase
{
    public function test_tostring_method(): void
    {
        $captionsCollection = new CaptionsCollection();
        $capOneCaption = 'Caption 1';
        $capTwoCaption = 'Caption 2';
        $captionString = $capOneCaption.' '.$capTwoCaption;
        $capOne = new Caption();
        $capOne->setCaption($capOneCaption);
        $capTwo = new Caption();
        $capTwo->setCaption($capTwoCaption);
        $captionsCollection->addCaption($capOne);
        $captionsCollection->addCaption($capTwo);
        $this->assertEquals($captionString, $captionsCollection->tostring());

    }
}
