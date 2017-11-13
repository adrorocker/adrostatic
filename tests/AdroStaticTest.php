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
        $root = dirname(__DIR__).'/files/';
        $as = new AdroStatic($root);
        $this->assertInstanceOf(AdroStatic::class, $as);
    }

    public function testAdroStaticAttic()
    {
        $root = dirname(__DIR__).'/files/';
        $as = new AdroStatic($root);
        $this->assertInstanceOf(AdroStatic::class, AdroStatic::attic());
    }

    public function testAdroStaticGetContainer()
    {
        $root = dirname(__DIR__).'/files/';
        $as = new AdroStatic($root);
        $this->assertInstanceOf(Container::class, AdroStatic::attic()->getContainer());
    }

    public function testAdroStaticFactory()
    {
        $root = dirname(__DIR__).'/files/';
        $as = new AdroStatic($root);
        $this->assertInstanceOf(AdroStatic::class, $as);
    }

    public function testAdroStaticGet()
    {
        $root = dirname(__DIR__).'/files/';
        $as = new AdroStatic($root);
        $this->assertSame($root, $as->get('rootPath'));
        $this->assertSame(null, $as->get('non'));
        $this->assertInstanceOf(Filesystem::class, $as->get('filesystem'));
        $this->assertInstanceOf(Config::class, $as->get('config'));
    }
}
