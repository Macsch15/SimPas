<?php
use Application\Security\DataFilters\PreDatabaseSave;

class PreDatabaseFilterTest extends PHPUnit_Framework_TestCase
{
    public function testPredbfilterRestrictedCharacters()
    {
        $this->assertEquals('example.string', (new PreDatabaseSave)->filter('#example*.string', true));
    }

    public function testPredbfilter()
    {
        $this->assertEquals('#example*.string', (new PreDatabaseSave)->filter('#example*.string', false));
    }
}
