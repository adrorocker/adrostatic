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
use AdroStatic\Content\Page\Category;
use AdroStatic\Content\Secction\Navigation;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
    public function testConstructorException()
    {
        $attributes = [];
        $this->expectException(InvalidArgumentException::class);
        $page = new Category('', $attributes);
    }

    public function testConstructor()
    {
        $attributes = ['title' => 'My Page'];
        $page = new Category('Linux', '', $attributes);
        $this->assertInstanceOf(Category::class, $page);
    }
}
