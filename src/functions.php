<?php
/**
 * AdroStatic.
 *
 * @copyright Copyright (c) 2017 Alejandro Morelos
 *
 * @link      https://github.com/adrorocker/adrostatic
 */

function container()
{
    return AdroStatic\AdroStatic::attic()->getContainer();
}

function isAssoc(array $arr)
{
    if ([] === $arr) {
        return false;
    }

    return array_keys($arr) !== range(0, count($arr) - 1);
}

function startsWith($haystack, $needle)
{
    $length = strlen($needle);

    return substr($haystack, 0, $length) === $needle;
}

function endsWith($haystack, $needle)
{
    $length = strlen($needle);

    return $length === 0 ||
    (substr($haystack, -$length) === $needle);
}
