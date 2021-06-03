<?php

use SimPas\HttpRequest\HttpRequest;
use PHPUnit\Framework\TestCase;

class HttpRequestTest extends TestCase
{
    public function testHttpRequestPostActionDoesNotExists()
    {
        $this->assertFalse(HttpRequest::post('not_existing_field'));
    }
}
