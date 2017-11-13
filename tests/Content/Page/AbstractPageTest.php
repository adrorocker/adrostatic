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
use AdroStatic\Content\Page\Page;
use AdroStatic\Content\Secction\Navigation;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class AbstractPageTest extends TestCase
{
    public function testConstructorException()
    {
        $attributes = [];
        $this->expectException(InvalidArgumentException::class);
        $page = new Page('', $attributes);
    }

    public function testConstructor()
    {
        $attributes = ['title' => 'My Page'];
        $page = new Page('', $attributes);
        $this->assertInstanceOf(Page::class, $page);
    }

    public function testSetSlug()
    {
        $attributes = ['title' => 'My Page', 'slug' => 'my-page'];
        $page = new Page('', $attributes);
        $this->assertInstanceOf(Page::class, $page);
    }

    public function testSetInNavNameException()
    {
        $attributes = ['title' => 'My Page', 'nav' => true];
        $this->expectException(InvalidArgumentException::class);
        $page = new Page('', $attributes);
    }

    public function testSetInNavWeightException()
    {
        $attributes = ['title' => 'My Page', 'nav' => ['name' => 'My Page']];
        $this->expectException(InvalidArgumentException::class);
        $page = new Page('', $attributes);
    }

    public function testSetInNav()
    {
        $attributes = [
            'title' => 'My Page',
            'nav'   => [
                'name'   => 'My Page',
                'weight' => 0,
            ],
        ];
        $page = new Page('', $attributes);

        $this->assertInstanceOf(Page::class, $page);
        $this->assertTrue($page->isInNav());
    }

    public function testGetNavItem()
    {
        $attributes = [
            'title' => 'My Page',
            'nav'   => [
                'name'   => 'My Page',
                'weight' => 0,
            ],
        ];
        $page = new Page('', $attributes);

        $this->assertInstanceOf(Navigation\Item::class, $page->getNavItem());
    }

    public function testGetTitle()
    {
        $attributes = [
            'title' => 'My Page',
        ];
        $page = new Page('', $attributes);

        $this->assertSame('My Page', $page->getTitle());
    }

    public function testGetContent()
    {
        $attributes = [
            'title' => 'My Page',
        ];
        $page = new Page('', $attributes);

        $this->assertSame('', $page->getContent());
    }

    public function testGetLink()
    {
        $attributes = [
            'title' => 'My Page',
        ];
        $page = new Page('', $attributes);

        $this->assertSame('/my-page/', $page->getLink());
    }

    public function testGetAttributes()
    {
        $attributes = [
            'title' => 'My Page',
        ];
        $page = new Page('', $attributes);

        $this->assertSame($attributes, $page->getAttributes());
    }
}
