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
use AdroStatic\Renderer\Post;
use PHPUnit\Framework\TestCase;

class PostRendererTest extends TestCase
{
    public function testConstructor()
    {
        $root = dirname(__DIR__).'/files/';
        $as = new AdroStatic($root);
        $r = new Post();
        $this->assertInstanceOf(Post::class, $r);
    }

    public function testSetCategories()
    {
        $root = dirname(__DIR__).'/files/';
        $as = new AdroStatic($root);
        $r = new Post();

        $r = $r->setCategories(['linux' => 'AdroStatic']);
        $this->assertInstanceOf(Post::class, $r);

        $r = $r->renderCategories();

        $this->assertInstanceOf(Post::class, $r);
    }

    public function testRender()
    {
        $root = dirname(__DIR__).'/files/';
        $as = new AdroStatic($root);
        $r = new Post();

        $content = $r->render('AdroStatic', ['title' => 'AdroStatic']);
        $this->assertTrue(is_string($content));
    }
}
