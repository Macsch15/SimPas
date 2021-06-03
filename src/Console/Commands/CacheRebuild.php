<?php

namespace SimPas\Console\Commands;

use SimPas\Application;
use SimPas\Console\Console;
use SimPas\Pastebin\SyntaxHighlighter;
use SimPas\View\View;
use Exception;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Twig_Error_Loader;
use Twig_Error_Syntax;

class CacheRebuild extends View
{
    private $console;

    /**
     * CacheRebuild constructor.
     * @param Console $console
     * @param Application $application
     * @throws Twig_Error_Loader
     * @throws Twig_Error_Syntax
     */
    public function __construct(Console $console, Application $application)
    {
        parent::__construct($application);

        $this->console = $console;

        $this->clear();
        $this->build();
    }

    /**
     * Remove existing cache.
     *
     * @return void
     */
    private function clear()
    {
        $this->console->writeStdout('Removing cache...', false, ' ');

        try {
            foreach (new RecursiveIteratorIterator(
                         new RecursiveDirectoryIterator(Application::makePath('storage'), RecursiveDirectoryIterator::SKIP_DOTS),
                         RecursiveIteratorIterator::SELF_FIRST,
                         RecursiveIteratorIterator::CATCH_GET_CHILD
                     ) as $file
            ) {
                if ($file->getFileName() === '.htaccess') {
                    continue;
                }

                if ($file->isDir()) {
                    @rmdir($file->getRealPath());
                } else {
                    @unlink($file->getRealPath());
                }
            }

            $this->console->writeStdout('Succeeded');
        } catch (Exception $exeption) {
            $this->console->writeStdout('Failed');
        }
    }

    /**
     * Build the cache files.
     *
     * @return void
     * @throws Twig_Error_Syntax
     * @throws Twig_Error_Loader
     */
    private function build()
    {
        $this->console->writeStdout('Building cache for templates...', false, ' ');

        if (count($this->regenerateTemplateCache(true))) {
            $this->console->writeStdout('Succeeded');
        } else {
            $this->console->writeStdout('Failed');
        }

        $this->console->writeStdout('Building cache for GeSHi...', false, ' ');

        if (is_int((new SyntaxHighlighter())->storageDataToCache(true))) {
            $this->console->writeStdout('Succeeded');
        } else {
            $this->console->writeStdout('Failed');
        }
    }
}
