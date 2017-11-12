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

class Blog extends AbstractPage
{
    protected $posts;

    public function __construct($content = '', $attributes = [], $filePath = null, $posts = [])
    {
        parent::__construct($content, $attributes, $filePath);
        $this->posts = $posts;
    }

    protected function setSlug($attributes)
    {
        $this->slug = null;

        return $this;
    }

    protected function setLink($attributes)
    {
        $this->link = '/blog/';

        return $this;
    }

    protected function setInNav($attributes)
    {
        $this->inNav = true;
        if (!isset($attributes['nav']['name'])) {
            $attributes['nav']['name'] = $this->title;
        }
        $attributes['nav']['weight'] = 10000;
        $this->navItem = new Navigation\Item(
            $this->link,
            $attributes['nav']['name'],
            $attributes['nav']['weight']
        );

        return $this;
    }
}
