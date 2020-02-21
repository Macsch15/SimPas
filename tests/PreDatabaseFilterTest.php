<?php
use PHPUnit\Framework\TestCase;
use Application\Security\DataFilters\PreDatabaseSave;

class PreDatabaseFilterTest extends TestCase
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
