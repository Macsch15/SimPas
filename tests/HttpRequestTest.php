<?php
use Application\HttpRequest\HttpRequest;

class HttpRequestTest extends PHPUnit_Framework_TestCase
{
    public function testHttpRequestPostActionDoesNotExists()
    {
        $this->assertFalse(HttpRequest::post('not_existing_field'));
    }
}
