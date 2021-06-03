<?php

use SimPas\Pastebin\ShortenUrlApi;
use PHPUnit\Framework\TestCase;

class ShortenUrlTest extends TestCase
{
    public function testShortenurlFail()
    {
        $this->assertNull((new ShortenUrlApi())->shorten('http//www.example.com'));
    }
}
