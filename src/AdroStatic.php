<?php
/**
 * AdroStatic.
 *
 * @link      https://github.com/adrorocker/adrostatic
 *
 * @copyright Copyright (c) 2017 Alejandro Morelos
 */

namespace AdroStatic;

use AdroStatic\Container\Container;

class AdroStatic
{
    /**
     * @var string
     */
    protected $root;

    /**
     * @var AdroStatic\Container\Container
     */
    protected $container;

    /**
     * @var AdroStatic\AdroStatic
     */
    protected static $instance;

    public static function attic()
    {
        return self::$instance;
    }

    public function __construct($root)
    {
        $this->root = $root;
        $this->container = new Container();
    }

    public function getContainer()
    {
        return $this->container;
    }

    public static function web($path)
    {
        return new self($path);
    }

    public function proxy()
    {
        echo 'AdroStatic';
    }
}
