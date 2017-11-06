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
use AdroStatic\Util;
use Cocur\Slugify\Slugify;
use InvalidArgumentException;

abstract class AbstractPage
{
    protected $title;

    protected $content;

    protected $slug;

    protected $link;

    protected $inNav;

    protected $navItem;

    protected $filePath;
    
    protected $attributes;

    public function __construct($content = '', $attributes = [], $filePath = null)
    {
        if (!isset($attributes['title'])) {
            throw new InvalidArgumentException('config => `title` must be set');
        }

        $this->filePath = $filePath;
        $this->attributes = $attributes;

        $this->setContent($content)
            ->setTitle($attributes)
            ->setSlug($attributes)
            ->setLink($attributes)
            ->setInNav($attributes);
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getLink()
    {
        return $this->link;
    }

    protected function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    protected function setTitle($attributes)
    {
        $this->title = $attributes['title'];

        return $this;
    }

    protected function setSlug($attributes)
    {
        $slug = $attributes['title'];
        if (isset($attributes['slug'])) {
            $slug = $attributes['slug'];
        }
        $this->slug = (new Slugify())->slugify($slug);

        return $this;
    }

    abstract protected function setLink($attributes);

    protected function setInNav($attributes)
    {
        $this->inNav = false;
        if (isset($attributes['nav'])) {
            if (!isset($attributes['nav']['name'])) {
                throw new InvalidArgumentException('nav => `name` must be set');
            }

            if (!isset($attributes['nav']['weight'])) {
                throw new InvalidArgumentException('nav => `weight` must be set');
            }

            $this->inNav = true;

            $this->navItem = new Navigation\Item(
                $this->link,
                $attributes['nav']['name'],
                $attributes['nav']['weight']
            );
        }
        return $this;
    }

    public function isInNav()
    {
        return $this->inNav;
    }

    public function getNavItem()
    {
        return $this->navItem;
    }

    public function getFilePath()
    {
        return $this->filePath;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }
}
