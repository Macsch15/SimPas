<?php

use SimPas\Helpers\Strings;
use PHPUnit\Framework\TestCase;

class StringToBytesTest extends TestCase
{
    public function testStringToBytes()
    {
        $test_string = 'Lorem ipsum Labore veniam tempor mollit aute do cupidatat id aliquip ullamco sit ut.';
        $expected = 84;

        $this->assertEquals($expected, Strings::stringToBytes($test_string));
    }
}
