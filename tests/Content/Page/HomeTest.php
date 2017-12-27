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
use AdroStatic\Content\Page\Home;
use AdroStatic\Content\Secction\Navigation;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class HomeTest extends TestCase
{
    public function testConstructorException()
    {
        $attributes = [];
        $this->expectException(InvalidArgumentException::class);
        $page = new Home('', $attributes);
    }

    public function testConstructor()
    {
        $attributes = ['title' => 'My Page'];
        $page = new Home('', $attributes);
        $this->assertInstanceOf(Home::class, $page);
    }
}
