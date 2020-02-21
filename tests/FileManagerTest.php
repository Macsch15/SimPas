<?php

use Application\Exception\ExceptionInvalidArgument;
use PHPUnit\Framework\TestCase;
use Application\FileManager\FileManager;

class FileManagerTest extends TestCase
{
    public function testFilemanagerNotExistingFile()
    {
        $this->assertFalse((new FileManager)->getContentsFromFile('SomeFile'));
    }

    /**
     * @throws \Application\Exception\ExceptionRuntime
     * @throws ExceptionInvalidArgument
     */
    public function testFilemanagerNotExistingUrl()
    {
        $this->expectException(ExceptionInvalidArgument::class);

        (new FileManager)->getContentsFromUrl('://www..com');
    }
}
