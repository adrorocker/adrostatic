<?php
/**
 * AdroStatic.
 *
 * @link      https://github.com/adrorocker/adrostatic
 *
 * @copyright Copyright (c) 2017 Alejandro Morelos
 */

namespace AdroStatic\Test\Container;

use AdroStatic\Container\Container;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    public function testContainerGet()
    {
        $container = new Container();
        $container['me'] = function($container) {
            return 'me';
        };
        $this->assertSame('me', $container->get('me'));
        $this->assertSame(null, $container->get('me2'));
        $this->assertSame(null, $container->me2);
    }

    public function testContainerIsset()
    {
        $container = new Container();

        $this->assertSame(false, isset($container->me2));
    }
}
