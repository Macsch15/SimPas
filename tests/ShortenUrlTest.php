<?php
use Application\Pastebin\ShortenUrlApi;

class ShortenUrlTest extends PHPUnit_Framework_TestCase
{
    public function testShortenurlFail()
    {
        $this->assertNull((new ShortenUrlApi)->shorten('http//www.example.com'));
    }
}
