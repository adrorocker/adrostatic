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
        $as = new AdroStatic(__DIR__);
        $this->assertInstanceOf(Config::class, Util::config());
        $this->assertSame(null, Util::configNon());
    }
}
