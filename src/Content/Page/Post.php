<?php
/**
 * AdroStatic.
 *
 * @copyright Copyright (c) 2017 Alejandro Morelos
 *
 * @link      https://github.com/adrorocker/adrostatic
 */

namespace AdroStatic\Content\Page;

class Post extends AbstractPage
{
    protected function setLink($data)
    {
        $this->link = '/blog/' . $this->slug;

        return $this;
    }
}
