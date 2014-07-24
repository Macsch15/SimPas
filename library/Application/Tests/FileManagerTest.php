<?php
use Application\FileManager\FileManager;

class FileManagerTest extends PHPUnit_Framework_TestCase
{
    public function testFilemanagerNotExistingFile()
    {
        $this->assertFalse((new FileManager)->getContentsFromFile('SomeFile'));
    }

    public function testFilemanagerNotExistingUrl()
    {
        $this->assertFalse((new FileManager)->getContentsFromUrl('http://www..com'));
    }
}
