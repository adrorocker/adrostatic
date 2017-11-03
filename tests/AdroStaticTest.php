<?php
/**
 * AdroStatic.
 *
 * @link      https://github.com/adrorocker/adrostatic
 *
 * @copyright Copyright (c) 2017 Alejandro Morelos
 */

namespace AdroStatic\Test;

use AdroStatic\AdroStatic;
use AdroStatic\Container\Container;
use PHPUnit\Framework\TestCase;

class AdroStaticTest extends TestCase
{
    public function testAdroStatic()
    {
        $as = new AdroStatic(__DIR__);
        $this->assertInstanceOf(AdroStatic::class, $as);
    }

    public function testAdroStaticAttic()
    {
        $as = new AdroStatic(__DIR__);
        $this->assertInstanceOf(AdroStatic::class, AdroStatic::attic());
    }

    public function testAdroStaticGetContainer()
    {
        $as = new AdroStatic(__DIR__);
        $this->assertInstanceOf(Container::class, AdroStatic::attic()->getContainer());
    }

    public function testAdroStaticWeb()
    {
        $as = AdroStatic::web(__DIR__);
        $this->assertInstanceOf(AdroStatic::class, $as);
    }
}
