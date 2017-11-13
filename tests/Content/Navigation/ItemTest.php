<?php
/**
 * AdroStatic.
 *
 * @copyright Copyright (c) 2017 Alejandro Morelos
 *
 * @link      https://github.com/adrorocker/adrostatic
 */

namespace AdroStatic\Test\Content\Secction\Navigation;

use AdroStatic\AdroStatic;
use AdroStatic\Content\Secction\Navigation\Item;
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{
    public function testConstructor()
    {
        $item = new Item('/', 'Home', 0);
        $this->assertInstanceOf(Item::class, $item);
    }

    public function testGetLink()
    {
        $item = new Item('/', 'Home', 0);
        $this->assertSame('/', $item->getLink());
    }

    public function testetName()
    {
        $item = new Item('/', 'Home', 0);
        $this->assertSame('Home', $item->getName());
    }

    public function testGetWeight()
    {
        $item = new Item('/', 'Home', 0);
        $this->assertSame(0, $item->getWeight());
    }
}
