<?php
use Application\FileManager\FileManager;

class FileManagerTest extends PHPUnit_Framework_TestCase
{
    public function testFilemanagerNotExistingFile()
    {
        $this->assertFalse((new FileManager)->getContentsFromFile('SomeFile'));
    }

    /**
     * @expectedException Application\Exception\ExceptionInvalidArgument
     */
    public function testFilemanagerNotExistingUrl()
    {
        (new FileManager)->getContentsFromUrl('://www..com');
    }
}
