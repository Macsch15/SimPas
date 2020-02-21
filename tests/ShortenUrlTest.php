<?php
use PHPUnit\Framework\TestCase;
use Application\Pastebin\ShortenUrlApi;

class ShortenUrlTest extends TestCase
{
    public function testShortenurlFail()
    {
        $this->assertNull((new ShortenUrlApi)->shorten('http//www.example.com'));
    }
}
