<?php
/**
 * AdroStatic.
 *
 * @copyright Copyright (c) 2017 Alejandro Morelos
 *
 * @link      https://github.com/adrorocker/adrostatic
 */

namespace AdroStatic\Test;

use AdroStatic\AdroStatic;
use AdroStatic\Config\Config;
use AdroStatic\Container\Container;
use League\Flysystem\Filesystem;
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

    public function testAdroStaticFactory()
    {
        $as = AdroStatic::factory(__DIR__);
        $this->assertInstanceOf(AdroStatic::class, $as);
    }

    public function testAdroStaticGet()
    {
        $as = AdroStatic::factory(__DIR__);
        $this->assertSame(__DIR__, $as->get('rootPath'));
        $this->assertSame(null, $as->get('non'));
        $this->assertInstanceOf(Filesystem::class, $as->get('filesystem'));
        $this->assertInstanceOf(Config::class, $as->get('config'));
    }
}
