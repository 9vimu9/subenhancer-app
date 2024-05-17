<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\DataObjects\Captions\CaptionsCollection;
use App\Services\SrtParser\BenlippStrParser;
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
        $captions = iterator_to_array($parser->parse($fileContent));
        $this->assertEquals('A Film Poeta Production', $captions[0]->getCaption());
        $this->assertEquals(63063, $captions[0]->getStartTime());
        $this->assertEquals(66148, $captions[0]->getEndTime());

        $this->assertEquals('A DIRTY CARNIVAL', $captions[1]->getCaption());
        $this->assertEquals(68443, $captions[1]->getStartTime());
        $this->assertEquals(73864, $captions[1]->getEndTime());

    }
}
