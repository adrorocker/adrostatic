<?php
/**
 * AdroStatic.
 *
 * @copyright Copyright (c) 2017 Alejandro Morelos
 *
 * @link      https://github.com/adrorocker/adrostatic
 */

namespace AdroStatic\Renderer;

class Home extends AbstractRenderer
{
    public function render($content, $data = [])
    {
        $data = array_merge(['menu' => $this->menu], $data);

        return $this->engine->addData($data)->render('home', ['content' => $content]);
    }
}
