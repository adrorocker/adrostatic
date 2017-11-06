<?php
/**
 * AdroStatic.
 *
 * @copyright Copyright (c) 2017 Alejandro Morelos
 *
 * @link      https://github.com/adrorocker/adrostatic
 */

namespace AdroStatic\Content\Page;

class Page extends AbstractPage
{
    protected function setLink($attributes)
    {
        $this->link = "/$this->slug/";

        return $this;
    }
}
