<?php
/**
 * AdroStatic.
 *
 * @copyright Copyright (c) 2017 Alejandro Morelos
 *
 * @link      https://github.com/adrorocker/adrostatic
 */

namespace AdroStatic\Test\Page;

use AdroStatic\AdroStatic;
use AdroStatic\Content\Page\Post;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class PostTest extends TestCase
{
    public function testConstructorException()
    {
        $attributes = [];
        $this->expectException(InvalidArgumentException::class);
        $page = new Post('', $attributes);
    }

    public function testConstructor()
    {
        $attributes = ['title' => 'My Page'];
        $page = new Post('', $attributes);
        $this->assertInstanceOf(Post::class, $page);
    }
}
