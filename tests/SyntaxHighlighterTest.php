<?php

use Application\Pastebin\SyntaxHighlighter;
use PHPUnit\Framework\TestCase;

class SyntaxHighlighterTest extends TestCase
{
    public function testSyntaxHighligherCount()
    {
        $this->assertCount(216, (new SyntaxHighlighter())->languagesToArray());
    }

    public function testSyntaxHighligherParser()
    {
        $parse = preg_replace("/[\t\n\s]+/", '', (new SyntaxHighlighter())->parseCode('Example Text', 'Text'));

        $expected = '<preclass="textpre_code"id="zclip_copy"style="font-family:monospace;"><ol><listyle="font-weight:normal;vertical-align:top;font-size:14px"><divstyle="font:normalnormal1em/1.2emmonospace;margin:0;padding:0;background:none;vertical-align:top;">ExampleText</div></li></ol></pre>';

        $this->assertEquals($expected, $parse);
    }
}
