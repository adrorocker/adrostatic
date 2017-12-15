<?php
/**
 * AdroStatic.
 *
 * @copyright Copyright (c) 2017 Alejandro Morelos
 *
 * @link      https://github.com/adrorocker/adrostatic
 */

namespace AdroStatic\Content\Page;

class Category extends AbstractPage
{
    protected $name;

    protected $posts;

    public function __construct($name, $content = '', $attributes = [], $filePath = null, $posts = [])
    {
        $this->posts = $posts;
        $this->name = $name;
        parent::__construct($content, $attributes, $filePath);
    }

    protected function setSlug($attributes)
    {
        $this->slug = '/blog/'.$this->name.'/';

        return $this;
    }

    protected function setLink($attributes)
    {
        $this->link = '/blog/'.$this->name.'/';

        return $this;
    }

    protected function setInNav($attributes)
    {
        $this->inNav = false;

        return $this;
    }
}
