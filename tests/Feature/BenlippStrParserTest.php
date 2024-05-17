<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Apis\SrtParser\BenlippStrParser;
use App\DataObjects\Captions\Caption;
use App\DataObjects\Captions\CaptionsCollection;
use Tests\TestCase;

class BenlippStrParserTest extends TestCase
{
    public function test_parse_method(): void
    {
        $fileContent =
            '1
00:01:03,063 --> 00:01:06,148
A Film Poeta Production

2
00:01:08,443 --> 00:01:13,864
A DIRTY CARNIVAL';

        $parser = new BenlippStrParser(new CaptionsCollection());
        $expected = new CaptionsCollection(
            new Caption(captionString: 'A Film Poeta Production', startTime: 63063, endTime: 66148),
            new Caption(captionString: 'A DIRTY CARNIVAL', startTime: 68443, endTime: 73864),
        );
        $captions = $parser->parse($fileContent);
        $this->assertEqualsCanonicalizing($expected, $captions);
    }
}
