<?php
/**
 * AdroStatic.
 *
 * @copyright Copyright (c) 2017 Alejandro Morelos
 *
 * @link      https://github.com/adrorocker/adrostatic
 */

namespace AdroStatic\Renderer;

class Post extends AbstractRenderer
{
    protected $categories = [];
    protected $categoriesContent = '';

    public function setCategories(array $categories)
    {
        $this->categories = array_keys($categories);

        return $this;
    }

    public function renderCategories($data = [])
    {
        $this->categoriesContent = $this->engine->addData($data)->render(
            'blog-categories',
            ['categories' => $this->categories]
        );


        return $this;
    }

    public function render($content, $data = [])
    {
        $data = array_merge([
            'menu' => $this->menu,
            'categories' => $this->categoriesContent,
        ], $data);

        return $this->engine->addData($data)->render('post', ['content' => $content]);
    }
}
