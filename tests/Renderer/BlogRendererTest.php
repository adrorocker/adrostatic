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
use AdroStatic\Renderer\Blog;
use PHPUnit\Framework\TestCase;

class BlogRendererTest extends TestCase
{
    protected static $renderer;

    protected static $as;

    public static function setUpBeforeClass()
    {
        $root = dirname(__DIR__).'/files/';
        self::$as = new AdroStatic($root);
        self::$renderer = new Blog();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(Blog::class, self::$renderer);
    }

    public function testSetCategories()
    {
        $r = self::$renderer->setCategories(['linux']);
        $this->assertInstanceOf(Blog::class, $r);
    }

    public function testSetPosts()
    {
        $r = self::$renderer->setPosts([]);
        $this->assertInstanceOf(Blog::class, $r);
    }

    public function testRenderCategories()
    {
        $content = self::$renderer->renderCategories();
        $this->assertTrue(is_string($content));
    }

    public function testRenderContent()
    {
        $content = self::$renderer->renderContent('', []);
        $this->assertTrue(is_string($content));
    }

    public function testRender()
    {
        $content = self::$renderer->render('AdroStatic', ['title' => 'AdroStatic']);
        $this->assertTrue(is_string($content));
    }
}
