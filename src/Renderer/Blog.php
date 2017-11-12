<?php
/**
 * AdroStatic.
 *
 * @copyright Copyright (c) 2017 Alejandro Morelos
 *
 * @link      https://github.com/adrorocker/adrostatic
 */

namespace AdroStatic\Renderer;

class Blog extends AbstractRenderer
{
    protected $categories = [];
    protected $posts = [];

    public function setCategories(array $categories)
    {
        $this->categories = array_keys($categories);

        return $this;
    }

    public function setPosts(array $posts)
    {
        $this->posts = $posts;

        return $this;
    }

    public function renderCategories($data = [])
    {
        return $this->engine->addData($data)->render(
            'blog-categories',
            ['categories' => $this->categories]
        );
    }

    public function renderContent($categories = '', $data = [])
    {
        return $this->engine->addData($data)->render(
            'blog-content',
            ['posts' => $this->posts,'categories' => $categories]
        );
    }

    public function render($content = [], $data = [])
    {
        $data = array_merge(['menu' => $this->menu], $data);
        return $this->engine->addData($data)->render('blog', ['content' => $content]);
    }
}
