<?php
/**
 * AdroStatic.
 *
 * @copyright Copyright (c) 2018 Alejandro Morelos
 *
 * @link      https://github.com/adrorocker/adrostatic
 */

namespace AdroStatic\Test\Renderer;

use AdroStatic\AdroStatic;
use AdroStatic\Content\Page\Home;
use AdroStatic\Renderer\Navigation;
use PHPUnit\Framework\TestCase;

class NavigationRendererTest extends TestCase
{
    public function testStatic()
    {
        $page = new Home('', [
            'title' => 'Home',
        ]);
        $renderer = Navigation::build([$page]);
        $this->assertInstanceOf(Navigation::class, $renderer);

        $content = $renderer->render([]);
        $this->assertTrue(is_string($content));
    }
}
