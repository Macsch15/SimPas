<?php
use Application\Pastebin\SyntaxHighlighter;

class SyntaxHighlighterTest extends PHPUnit_Framework_TestCase
{
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
}
