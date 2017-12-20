<?php
/**
 * AdroStatic.
 *
 * @copyright Copyright (c) 2017 Alejandro Morelos
 *
 * @link      https://github.com/adrorocker/adrostatic
 */

namespace AdroStatic\Renderer;

class Navigation extends AbstractRenderer
{
    protected $items;

    public function __construct(array $items)
    {
        parent::__construct();

        $this->items = $items;
    }

    public function render(array $data)
    {
        return $this->engine->addData($data)->render('menu', ['items' => $this->items]);
    }

    public static function build(array $pages = [])
    {
        $items = [];
        foreach ($pages as $page) {
            if ($page->isInNav()) {
                $items[$page->getNavItem()->getWeight()] = $page->getNavItem();
            }
        }

        ksort($items);

        return new self($items);
    }
}
