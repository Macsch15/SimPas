<?php
namespace Application\Console\Commands;

use Application\Application;
use Application\Console\Console;
use Application\View\View;
use Application\Pastebin\SyntaxHighlighter;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Exception;

class CacheRebuild extends View
{
    /**
     * Console
     * 
     * @var object
     */
    private $console;

    /**
     * Construct
     * 
     * @param Console $console
     * @param Application $application
     * @return void
     */
    public function __construct(Console $console, Application $application)
    {
        parent::__construct($application);

        $this->console = $console;

        // Remove cache
        $this->clear();

        // Create cache
        $this->build();
    }

    /**
     * Remove existing cache
     * 
     * @return void
     */
    private function clear()
    {
        $this->console->writeStdout('Removing cache...', false, ' ');

        // try-catch
        try {
            foreach (new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator(Application::makePath('storage'), RecursiveDirectoryIterator::SKIP_DOTS), 
                RecursiveIteratorIterator::SELF_FIRST, RecursiveIteratorIterator::CATCH_GET_CHILD) as $file
            ) {
                if($file->getFileName() === '.htaccess') {
                    continue;
                }
                
                if($file->isDir()) {
                    // Remove directory
                    @rmdir($file->getRealPath());
                } else {
                    // Remove file
                    @unlink($file->getRealPath());
                }
            }

            $this->console->writeStdout('Succeeded');
        } catch(Exception $exeption) {
            $this->console->writeStdout('Failed');
        }
    }

    /**
     * Build the cache files
     * 
     * @return void
     */
    private function build()
    {
        $this->console->writeStdout('Building cache for templates...', false, ' ');

        // Create template cache
        if (count($this->regenerateTemplateCache(true))) {
            $this->console->writeStdout('Succeeded');
        } else {
            $this->console->writeStdout('Failed');
        }

        $this->console->writeStdout('Building cache for GeSHi...', false, ' ');

        // Create GeSHi cache
        if (is_int((new SyntaxHighlighter)->storageDataToCache(true))) {
            $this->console->writeStdout('Succeeded');
        } else {
            $this->console->writeStdout('Failed');
        }
    }
}
