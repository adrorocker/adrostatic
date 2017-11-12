<?php
/**
 * AdroStatic.
 *
 * @copyright Copyright (c) 2017 Alejandro Morelos
 *
 * @link      https://github.com/adrorocker/adrostatic
 */

namespace AdroStatic\Renderer;

use AdroStatic\Util;
use League\Plates\Engine;

abstract class AbstractRenderer
{
    protected $engine;

    protected $menu;

    public function __construct()
    {
        $dir  = Util::config()->get('themes.dir');
        $path  = Util::rootPath() . '/' . $dir;
        $theme  = $path . '/' . Util::config()->get('theme') . '/';

        $this->engine =  new Engine($theme);
    }

    public function setMenu($menu)
    {
        $this->menu = $menu;

        return $this;
    }
}
