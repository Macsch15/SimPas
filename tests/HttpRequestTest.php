<?php
use PHPUnit\Framework\TestCase;
use Application\HttpRequest\HttpRequest;

class HttpRequestTest extends TestCase
{
    public function testHttpRequestPostActionDoesNotExists()
    {
        $this->assertFalse(HttpRequest::post('not_existing_field'));
    }
}
