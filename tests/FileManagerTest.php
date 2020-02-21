<?php

use Application\Exception\ExceptionInvalidArgument;
use Application\FileManager\FileManager;
use PHPUnit\Framework\TestCase;

class FileManagerTest extends TestCase
{
    public function testFilemanagerNotExistingFile()
    {
        $this->assertFalse((new FileManager())->getContentsFromFile('SomeFile'));
    }

    /**
     * @throws \Application\Exception\ExceptionRuntime
     * @throws ExceptionInvalidArgument
     */
    public function testFilemanagerNotExistingUrl()
    {
        $this->expectException(ExceptionInvalidArgument::class);

        (new FileManager())->getContentsFromUrl('://www..com');
    }
}
