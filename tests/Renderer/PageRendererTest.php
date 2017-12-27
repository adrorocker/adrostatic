<?php
/**
 * AdroStatic.
 *
 * @copyright Copyright (c) 2017 Alejandro Morelos
 *
 * @link      https://github.com/adrorocker/adrostatic
 */

namespace AdroStatic\Test\Renderer;

use AdroStatic\AdroStatic;
use AdroStatic\Renderer\Page;
use PHPUnit\Framework\TestCase;

class PageRendererTest extends TestCase
{
    public function testConstructor()
    {
        $root = dirname(__DIR__).'/files/';
        $as = new AdroStatic($root);
        $r = new Page();
        $this->assertInstanceOf(Page::class, $r);
    }

    public function testRender()
    {
        $root = dirname(__DIR__).'/files/';
        $as = new AdroStatic($root);
        $r = new Page();

        $content = $r->render('AdroStatic', ['title' => 'AdroStatic']);
        $this->assertTrue(is_string($content));
    }
}
