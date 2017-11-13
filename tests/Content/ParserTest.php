<?php
/**
 * AdroStatic.
 *
 * @copyright Copyright (c) 2017 Alejandro Morelos
 *
 * @link      https://github.com/adrorocker/adrostatic
 */

namespace AdroStatic\Test;

use AdroStatic\AdroStatic;
use AdroStatic\Content\Parser;
use PHPUnit\Framework\TestCase;
use SplFileInfo;

class ParserTest extends TestCase
{
    public function testConstructor()
    {
        $root = dirname(__DIR__).'/files/';
        $as = new AdroStatic($root);
        $parser = new Parser(
            new SplFileInfo('content/index.md')
        );

        $this->assertInstanceOf(Parser::class, $parser);
    }

    public function testParse()
    {
        $root = dirname(__DIR__).'/files/';
        $as = new AdroStatic($root);

        $parser = new Parser(
            new SplFileInfo('content/index.md')
        );

        $parsed = $parser->parse();
        $this->assertSame($parser, $parsed);

        $parser = new Parser(
            new SplFileInfo('content/indexBad.md')
        );

        $parsed = $parser->parse();
        $this->assertSame($parser, $parsed);

        $parser = new Parser(
            new SplFileInfo('content/indexNoAtts.md')
        );

        $parsed = $parser->parse();
        $this->assertSame($parser, $parsed);

        $this->assertSame('content/indexNoAtts.md', $parsed->getPath());
        $this->assertSame([], $parsed->getAttributes());
        $this->assertSame('# AdroStatic', $parsed->getBody());
    }

    // public function testConstructor()
    // {
    //     $root = dirname(__DIR__).'/testFiles/';
    //     $as = new AdroStatic($root);

    //     $parser = new Parser(
    //         new SplFileInfo('content/index.md')
    //     );

    //     $parsed = $parser->parse();
    //     $this->assertSame($parser, $parsed);
    // }
}
