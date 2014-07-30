<?php
use Application\Pastebin\Helpers\PasteId;

class PasteIdFromUrlTest extends PHPUnit_Framework_TestCase
{
    public function testIdPasteFromUrlTrue()
    {
        $valid_link = 'http://localhost/SimPas/develop/paste/12057641080';

        $expected = '12057641080';

        $this->assertEquals($expected, PasteId::getFromUrl($valid_link));
    }

    public function testIdPasteFromUrlFalse()
    {
        $invalid_link = 'http://localhost/lorem/ipsum/ipsum/1144775/test';

        $this->assertFalse(PasteId::getFromUrl($invalid_link));
    }
}
