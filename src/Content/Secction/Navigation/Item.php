<?php
/**
 * AdroStatic.
 *
 * @copyright Copyright (c) 2017 Alejandro Morelos
 *
 * @link      https://github.com/adrorocker/adrostatic
 */

namespace AdroStatic\Content\Secction\Navigation;

class Item
{
    protected $name;

    protected $weight;

    protected $link;

    public function __construct($link, $name, $weight)
    {
        $this->link = $link;
        $this->name = $name;
        $this->weight = $weight;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function getLink()
    {
        return $this->link;
    }

    public function getName()
    {
        return $this->name;
    }
}
