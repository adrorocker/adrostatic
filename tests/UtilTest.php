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
use AdroStatic\Util;
use PHPUnit\Framework\TestCase;

class UtilTest extends TestCase
{
    public function testCallStatic()
    {
        $root = realpath(__DIR__).'/testFiles/';
        $as = new AdroStatic($root);
        $this->assertInstanceOf(Config::class, Util::config());
        $this->assertSame(null, Util::configNon());
    }

    public function testMapExist()
    {
        $root = realpath(__DIR__).'/testFiles/';
        $as = new AdroStatic($root);
        $this->assertTrue(Util::mapExist());
    }

    public function testMapHashFromFiles()
    {
        $hash = md5(implode('-', ['adro']));
        $this->assertSame($hash, Util::mapHashFromFiles(['adro']));
    }

    // public function testGetMapHash()
    // {
    //     $root = realpath(__DIR__).'/testFiles/';
    //     $as = new AdroStatic($root);

    //     $_SERVER['REQUEST_URI'] = '/';
    //     $test = Util::getMapHash();

    //     $this->assertSame(true, true);
    // }
}
