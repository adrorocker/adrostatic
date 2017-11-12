<?php
/**
 * AdroStatic.
 *
 * @copyright Copyright (c) 2017 Alejandro Morelos
 *
 * @link      https://github.com/adrorocker/adrostatic
 */
if (!function_exists('dd')) {
    ini_set('xdebug.var_display_max_depth', 8);
    ini_set('xdebug.var_display_max_children', 256);
    ini_set('xdebug.var_display_max_data', 1024);
    function dd(...$args)
    {
        $backtrace = debug_backtrace();
        $file = $backtrace[0]['file'];
        $line = $backtrace[0]['line'];
        echo "<font style='font-size: smaller;' color='green'>$file:$line</font>";
        foreach ($args as $x) {
            var_dump($x);
        }
        die(1);
    }
}

if (!function_exists('d')) {
    ini_set('xdebug.var_display_max_depth', 8);
    ini_set('xdebug.var_display_max_children', 256);
    ini_set('xdebug.var_display_max_data', 1024);
    function d(...$args)
    {
        $backtrace = debug_backtrace();
        $file = $backtrace[0]['file'];
        $line = $backtrace[0]['line'];
        echo "<pre><font style='font-size: smaller;' color='green'>$file:$line</font></pre>";
        foreach ($args as $x) {
            var_dump($x);
        }
    }
}
