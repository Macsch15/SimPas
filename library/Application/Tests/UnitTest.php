<?php
use Application\Autoloader;
use Application\Application;
use Application\HttpRequest\HttpRequest;
use Application\Pastebin\SyntaxHighlighter;
use Application\FileManager\FileManager;
use Application\Pastebin\ShortenUrlApi;
use Application\Security\DataFilters\PreDatabaseSave;

class Tests extends PHPUnit_Framework_TestCase
{
    public function __construct()
    {
        // Include autoloader
        require_once __DIR__ . '/../Autoloader.php';

        // Setup autoloader
        new Autoloader();
    }

    public function testHttpRequestPostActionDoesNotExists()
    {
        $this->assertFalse(HttpRequest::post('not_existing_field'));
    }

    public function testSyntaxHighligherCount()
    {
        $this->assertCount(217, (new SyntaxHighlighter)->languagesToArray());
    }

    public function testSyntaxHighligherParser()
    {
        $parse = preg_replace("/[\t\n\s]+/", '', (new SyntaxHighlighter)->parseCode('Example Text', 'Text'));

        $expected = '<preclass="textpre_code"id="zclip_copy"style="font-family:monospace;"><ol><ahref="#line-1"><liclass="line_handler"id="line-1"style="font-weight:normal;vertical-align:top;font-size:14px"><divstyle="font:normalnormal1em/1.2emmonospace;margin:0;padding:0;background:none;vertical-align:top;">ExampleText</div></li></a></ol></pre>';
        

        $this->assertEquals($expected, $parse);
    }

    public function testFilemanagerNotExistingFile()
    {
        $this->assertFalse((new FileManager)->getContentsFromFile('SomeFile'));
    }

    public function testFilemanagerNotExistingUrl()
    {
        $this->assertFalse((new FileManager)->getContentsFromUrl('http://www..com'));
    }

    public function testShortenurlFail()
    {
        $this->assertNull((new ShortenUrlApi)->shorten('http//www.example.com'));
    }

    public function testPredbfilterRC()
    {
        $this->assertEquals('example.string', (new PreDatabaseSave)->filter('#example*.string', true));
    }

    public function testPredbfilter()
    {
        $this->assertEquals('#example*.string', (new PreDatabaseSave)->filter('#example*.string', false));
    }
}
