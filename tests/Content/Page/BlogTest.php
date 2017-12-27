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
use AdroStatic\Content\Page\Blog;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class BlogTest extends TestCase
{
    public function testConstructorException()
    {
        $attributes = [];
        $this->expectException(InvalidArgumentException::class);
        $page = new Blog('', $attributes);
    }

    public function testConstructor()
    {
        $attributes = ['title' => 'My Page'];
        $page = new Blog('', $attributes);
        $this->assertInstanceOf(Blog::class, $page);
    }
}
