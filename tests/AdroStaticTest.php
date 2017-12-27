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
        $root = __DIR__.'/files/';
        $as = new AdroStatic($root);
        $this->assertInstanceOf(AdroStatic::class, $as);
    }

    public function testAdroStaticAttic()
    {
        $root = __DIR__.'/files/';
        $as = new AdroStatic($root);
        $this->assertInstanceOf(AdroStatic::class, AdroStatic::attic());
    }

    public function testAdroStaticGetContainer()
    {
        $root = __DIR__.'/files/';
        $as = new AdroStatic($root);
        $this->assertInstanceOf(Container::class, AdroStatic::attic()->getContainer());
    }

    public function testAdroStaticFactory()
    {
        $root = __DIR__.'/files/';
        $as = AdroStatic::factory($root);
        $this->assertInstanceOf(AdroStatic::class, $as);
    }

    public function testAdroStaticGet()
    {
        $root = __DIR__.'/files/';
        $as = new AdroStatic($root);
        $this->assertSame($root, $as->get('rootPath'));
        $this->assertSame(null, $as->get('non'));
        $this->assertInstanceOf(Filesystem::class, $as->get('filesystem'));
        $this->assertInstanceOf(Config::class, $as->get('config'));
    }

    public function testAdroStaticProxy()
    {
        $root = __DIR__.'/files/';
        $_SERVER = array_merge($_SERVER, ['URI' => '/']);
        $as = new AdroStatic($root, new Config([
            'theme'   => 'v1',
            'content' => [
                'dir' => 'clean',
            ],
        ]));

        ob_start();
        $as->proxy();
        $output = ob_get_contents();
        ob_end_clean();

        $this->assertTrue(is_string($output));
    }
}
