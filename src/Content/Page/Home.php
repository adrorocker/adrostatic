<?php
/**
 * AdroStatic.
 *
 * @copyright Copyright (c) 2017 Alejandro Morelos
 *
 * @link      https://github.com/adrorocker/adrostatic
 */

namespace AdroStatic\Content\Page;

use AdroStatic\Content\Secction\Navigation;

class Home extends AbstractPage
{
    protected function setSlug($attributes)
    {
        $this->slug = null;

        return $this;
    }

    protected function setLink($attributes)
    {
        $this->link = '/';

        return $this;
    }

    protected function setInNav($attributes)
    {
        $this->inNav = true;
        if (!isset($attributes['nav']['name'])) {
            $attributes['nav']['name'] = $this->title;
        }
        $attributes['nav']['weight'] = 0;
        $this->navItem = new Navigation\Item(
            $this->link,
            $attributes['nav']['name'],
            $attributes['nav']['weight']
        );

        return $this;
    }
}
