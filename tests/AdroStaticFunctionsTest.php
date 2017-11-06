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
use AdroStatic\Container\Container;
use PHPUnit\Framework\TestCase;

class AdroStaticFunctionsTest extends TestCase
{
    public function testContainerFunction()
    {
        $as = new AdroStatic(__DIR__);
        $this->assertInstanceOf(Container::class, container());
    }

    public function testStartsWith()
    {
        $this->assertTrue(startsWith('/index/', '/'));

        $this->assertFalse(startsWith('/index/', '\\'));
    }

    public function testEndsWith()
    {
        $this->assertTrue(endsWith('/index/', '/'));

        $this->assertFalse(endsWith('/index/', '\\'));
    }

    public function testIsAssoc()
    {
        $this->assertTrue(isAssoc(['key' => 'value']));

        $this->assertFalse(isAssoc(['value']));
        $this->assertFalse(isAssoc([]));
    }

    public function testDD()
    {
        $_ENV['testing'] = true;
        ob_start();
        d('static');
        $string = ob_get_contents();
        ob_end_clean();

        $this->expectOutputString($string);

        d('static');
    }
}
