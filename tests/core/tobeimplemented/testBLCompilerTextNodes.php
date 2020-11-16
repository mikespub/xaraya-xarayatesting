<?php

class testBLCompilerTextNodes1 extends xarTestCase
{
    public $myBLC;
    
    public function setup()
    {
        $GLOBALS['xarDebug'] = false;
        sys::import('blocklayout.compiler');
        $xslFile = 'blocklayout/xslt/xar2php.xsl';
        $this->myBLC = XarayaCompiler::instance();
    }
    
    public function precondition()
    {
        // not needed here
        return true;
    }

    public function teardown()
    {
        // not needed here
    }
    
    public function testHTMLComments()
    {
        $tplString  = '<xar:template xmlns:xar="http://xaraya.com/2004/blocklayout">';
        $tplString .= "<!-- \r\n sometext\r\n  -->";
        $tplString .= '</xar:template>';
        $expected   = "";
        $out = $this->myBLC->compileString($tplString);
        $this->expected = "Hex ".bin2hex($expected);
        $this->actual   = "Hex ".bin2hex($out);
        return $this->assertSame($out, $expected, "HTML comments are removed in the transform");
    }
    
    public function testxarComments()
    {
        $tplString  = '<xar:template xmlns:xar="http://xaraya.com/2004/blocklayout">';
        $tplString .= "<xar:comment> foo </xar:comment>";
        $tplString .= '</xar:template>';
        $expected   = "<!-- foo -->";
        $out = $this->myBLC->compileString($tplString);
        $this->expected = "Hex ".bin2hex($expected);
        $this->actual   = "Hex ".bin2hex($out);
        return $this->assertSame($out, $expected, "xar:comment tags become html comments");
    }

    public function testWinMultilineComments()
    {
        $tplString  = '<xar:template xmlns:xar="http://xaraya.com/2004/blocklayout">';
        $tplString .= "<xar:comment> \r\nfoo\r\n </xar:comment>";
        $tplString .= '</xar:template>';
        $expected   = "<!-- \r\nfoo\r\n -->";
        $out = $this->myBLC->compileString($tplString);
        $this->expected = "Hex ".bin2hex($expected);
        $this->actual   = "Hex ".bin2hex($out);
        return $this->assertSame($out, $expected, "BL multiline comments windows CR");
    }

    public function testMacMultilineComments()
    {
        $tplString  = '<xar:template xmlns:xar="http://xaraya.com/2004/blocklayout">';
        $tplString .="<xar:comment> \rfoo\r </xar:comment>";
        $tplString .= '</xar:template>';
        $expected   = "<!-- \rfoo\r -->";
        $out = $this->myBLC->compileString($tplString);
        $this->expected = "Hex ".bin2hex($expected);
        $this->actual   = "Hex ".bin2hex($out);
        return $this->assertSame($out, $expected, "BL multiline xar:comments mac CR");
    }

    public function testUnixMultilineComments()
    {
        $tplString  = '<xar:template xmlns:xar="http://xaraya.com/2004/blocklayout">';
        $tplString .="<xar:comment> \nsometext\n </xar:comment>";
        $tplString .= '</xar:template>';
        $expected   = "<!-- \nsometext\n -->";
        $out = $this->myBLC->compileString($tplString);
        $this->expected = "Hex ".bin2hex($expected);
        $this->actual   = "Hex ".bin2hex($out);
        return $this->assertSame($out, $expected, "BL multiline comments unix CR");
    }

    public function xtestWinBLComments()
    {
        $tplString  = '<xar:template xmlns:xar="http://xaraya.com/2004/blocklayout">';
        $tplString .="<!-- \r\n#\$foo#\r\n  -->";
        $tplString .= '</xar:template>';
        $expected   = "<!-- \r\n#\$foo#\r\n  -->";
        $out = $this->myBLC->compileString($tplString);
        return $this->assertSame($out, $expected, "BL multiline comments with windows CR");
    }
    public function xtestMacBLComments()
    {
        $tplString  = '<xar:template xmlns:xar="http://xaraya.com/2004/blocklayout">';
        $tplString .="<!--\r#\$foo#\r  -->";
        $tplString .= '</xar:template>';
        $expected   = "<!--\r#\$foo#\r  -->";
        $out = $this->myBLC->compileString($tplString);
        return $this->assertSame($out, $expected, "BL multiline comments with mac CR");
    }
    public function xtestUnixBLComments()
    {
        $tplString  = '<xar:template xmlns:xar="http://xaraya.com/2004/blocklayout">';
        $tplString .= "<!-- \n#\$foo#\n  -->";
        $tplString .= '</xar:template>';
        $expected   = "<!-- \n#\$foo#\n  -->";
        $out = $this->myBLC->compileString($tplString);
        return $this->assertSame($out, $expected, "BL multiline comments with unix CR");
    }

    public function testGeneralTagOpenForm()
    {
        $tplString  = '<xar:template xmlns:xar="http://xaraya.com/2004/blocklayout">';
        $tplString .= "<foo>bar</foo>";
        $tplString .= '</xar:template>';
        $expected   = "<foo>
  <?php echo xarML('bar');?>
</foo>";
        $expected1   = "<foo>\r\n  <?php echo xarML('bar');?>\r\n</foo>";
        $out = $this->myBLC->compileString($tplString);
        $this->expected = "Hex ".bin2hex($expected);
        $this->actual   = "Hex ".bin2hex($out);
        return $this->assertSame($out, $expected, "The open form of a tag in general is untouched");
    }
    
    public function testGeneralTagClosedForm()
    {
        $tplString  = '<xar:template xmlns:xar="http://xaraya.com/2004/blocklayout">';
        $tplString .= "<foo/>";
        $tplString .= '</xar:template>';
        $expected   = "<foo/>";
        $out = $this->myBLC->compileString($tplString);
        $this->expected = "Hex ".bin2hex($expected);
        $this->actual   = "Hex ".bin2hex($out);
        return $this->assertSame($out, $expected, "The closed form of a tag in general is untouched");
    }

    public function testHashVariable()
    {
        $tplString  = '<xar:template xmlns:xar="http://xaraya.com/2004/blocklayout">';
        $tplString .= "#\$foo#";
        $tplString .= '</xar:template>';
        $expected   = "<?php echo xarML(\$foo);?>";
        $out = $this->myBLC->compileString($tplString);
        return $this->assertSame($out, $expected, "Variable inside hashes is resolved as PHP");
    }

    public function testSimpleStringTextNode()
    {
        $tplString  = '<xar:template xmlns:xar="http://xaraya.com/2004/blocklayout">';
        $tplString .= "foo";
        $tplString .= '</xar:template>';
        $expected   = "<?php echo xarML('foo');?>";
        $out = $this->myBLC->compileString($tplString);
        $this->expected = $expected;
        $this->actual   = $out;
        return $this->assertSame($out, $expected, "A non-numeric text node containing no special chars is translatable");
    }

    public function testSimpleNumberTextNode()
    {
        $tplString  = '<xar:template xmlns:xar="http://xaraya.com/2004/blocklayout">';
        $tplString .= "666";
        $tplString .= '</xar:template>';
        $expected   = "666";
        $out = $this->myBLC->compileString($tplString);
        $this->expected = $expected;
        $this->actual   = $out;
        return $this->assertSame($out, $expected, "A text node representing a number is untouched");
    }

    public function testTextBeforeHashVariable()
    {
        $tplString  = '<xar:template xmlns:xar="http://xaraya.com/2004/blocklayout">';
        $tplString .= "foo#\$bar#";
        $tplString .= '</xar:template>';
        $expected   = "<?php echo xarML('foo'.\$bar);?>";
        $out = $this->myBLC->compileString($tplString);
        return $this->assertSame($out, $expected, "Text + hashvar is translatable");
    }

    public function testTextAfterHashVariable()
    {
        $tplString  = '<xar:template xmlns:xar="http://xaraya.com/2004/blocklayout">';
        $tplString .= "#\$bar#foo";
        $tplString .= '</xar:template>';
        $expected   = "<?php echo xarML(\$bar.'foo');?>";
        $out = $this->myBLC->compileString($tplString);
        return $this->assertSame($out, $expected, "Hashvar + text is translatable");
    }

    public function testTextBeforeAndAfterHashVariable()
    {
        $tplString  = '<xar:template xmlns:xar="http://xaraya.com/2004/blocklayout">';
        $tplString .= "foo#\$bar#oo";
        $tplString .= '</xar:template>';
        $expected   = "<?php echo xarML('foo'.\$bar.'oo');?>";
        $out = $this->myBLC->compileString($tplString);
        return $this->assertSame($out, $expected, "Text + hashvar + text is translatable");
    }

    public function testHashVariableBeforeAndAfterText()
    {
        $tplString  = '<xar:template xmlns:xar="http://xaraya.com/2004/blocklayout">';
        $tplString .= "#\$foo#bar#\$oo#";
        $tplString .= '</xar:template>';
        $expected   = "<?php echo xarML(\$foo.'bar'.\$oo);?>";
        $out = $this->myBLC->compileString($tplString);
        return $this->assertSame($out, $expected, "Hashvar + text + hashvar is translatable");
    }

    public function testTextWithDoubleHash()
    {
        $tplString  = '<xar:template xmlns:xar="http://xaraya.com/2004/blocklayout">';
        $tplString .= "foobar ##cccooo";
        $tplString .= '</xar:template>';
        $expected   = "<?php echo xarML('foobar #cccooo');?>";
        $out = $this->myBLC->compileString($tplString);
        return $this->assertSame($out, $expected, "Double hash in text should return 1 hash back");
    }

    public function testHashVarWithDoubleHash()
    {
        $tplString  = '<xar:template xmlns:xar="http://xaraya.com/2004/blocklayout">';
        $tplString .= "#\$foobar###cccooo";
        $tplString .= '</xar:template>';
        $expected   = "<?php echo xarML(\$foobar.'#cccooo');?>";
        $out = $this->myBLC->compileString($tplString);
        return $this->assertSame($out, $expected, "Hashvar and double hash should resolve and return 1 hash back");
    }

    public function testDoubleHashWithHashVar()
    {
        $tplString  = '<xar:template xmlns:xar="http://xaraya.com/2004/blocklayout">';
        $tplString .= "##cccooo#\$foobar#";
        $tplString .= '</xar:template>';
        $expected   = "<?php echo xarML('#cccooo'.\$foobar);?>";
        $out = $this->myBLC->compileString($tplString);
        return $this->assertSame($out, $expected, "Double hash and hashvar should resolve and return 1 hash back");
    }

    public function xtestDoubleHash()
    {
        $tplString  = '<xar:template xmlns:xar="http://xaraya.com/2004/blocklayout">';
        // Test for bug 694 and 695
        $tplString .= "#\$foo##";
        $tplString .= '</xar:template>';
        $expected   = "<?php echo \$foo; ?>#";
        $out = $this->myBLC->compileString($tplString);
        return $this->assertSame($out, $expected, "Double hash after variable should return 1 back");
    }

    public function xtestTripleHash()
    {
        $tplString  = '<xar:template xmlns:xar="http://xaraya.com/2004/blocklayout">';
        // Test for bug 694 and 695
        $tplString .= "foo###";
        $tplString .= '</xar:template>';
        $expected   = "<?php echo xarML('foo#'); ?>";
        $out = $this->myBLC->compileString($tplString);
        return $this->assertSame($out, $expected, "Triple hash after variable should return 1 back");
    }

    public function testHashVariableInxarComments()
    {
        $tplString  = '<xar:template xmlns:xar="http://xaraya.com/2004/blocklayout">';
        $tplString .= "<xar:comment><xar:var name=\"foo\" value=\"666\"/></xar:comment>";
        $tplString .= '</xar:template>';
        $expected   = "<!-- 666 -->";
        $out = $this->myBLC->compileString($tplString);
        $this->expected = $expected;
        $this->actual   = $out;
        return $this->assertSame($out, $expected, "Hash variables in xar:comment tags are resolved");
    }
}

$suite->AddTestCase('testBLCompilerTextNodes', 'Text node and comment handling');
