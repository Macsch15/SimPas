<?php

use SimPas\Exception\ExceptionInvalidArgument;
use SimPas\FileManager\FileManager;
use PHPUnit\Framework\TestCase;

class FileManagerTest extends TestCase
{
    public function testFilemanagerNotExistingFile()
    {
        $this->assertFalse((new FileManager())->getContentsFromFile('SomeFile'));
    }

    /**
     * @throws \SimPas\Exception\ExceptionRuntime
     * @throws ExceptionInvalidArgument
     */
    public function testFilemanagerNotExistingUrl()
    {
        $this->expectException(ExceptionInvalidArgument::class);

        (new FileManager())->getContentsFromUrl('://www..com');
    }
}
