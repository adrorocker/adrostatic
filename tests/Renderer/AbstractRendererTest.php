<?php
/**
 * AdroStatic.
 *
 * @copyright Copyright (c) 2017 Alejandro Morelos
 *
 * @link      https://github.com/adrorocker/adrostatic
 */

namespace AdroStatic\Test\Renderer;

use AdroStatic\AdroStatic;
use AdroStatic\Renderer\AbstractRenderer;
use PHPUnit\Framework\TestCase;

class AbstractRendererTest extends TestCase
{
    public function testContainerFunction()
    {
        $root = dirname(__DIR__).'/testFiles/';
        $as = new AdroStatic($root);
        $r = new Renderer();
        $this->assertInstanceOf(AbstractRenderer::class, $r);
    }
}

class Renderer extends AbstractRenderer
{
}
