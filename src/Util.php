<?php
/**
 * AdroStatic.
 *
 * @copyright Copyright (c) 2017 Alejandro Morelos
 *
 * @link      https://github.com/adrorocker/adrostatic
 */

namespace AdroStatic;

class Util
{
    public static function __callStatic($name, $arguments)
    {
        if (container()->has($name)) {
            return container()->get($name);
        }
    }
}
