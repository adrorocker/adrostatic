<?php
/**
 * AdroStatic.
 *
 * @copyright Copyright (c) 2017 Alejandro Morelos
 *
 * @link      https://github.com/adrorocker/adrostatic
 */

namespace AdroStatic\Test\Config;

use AdroStatic\AdroStatic;
use AdroStatic\Config\Config;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    public function testConfig()
    {
        $config = new Config();
        $this->assertInstanceOf(Config::class, $config);

        $config = new Config($config);
        $this->assertInstanceOf(Config::class, $config);

        $title = 'Static Site';

        $this->assertSame($title, $config->get('site.title'));

        $defaults = [
            'site' => [
                'title'        => 'Static Site',
                'baseline'     => 'A static website',
                'baseurl'      => 'http://localhost:8000/',
                'canonicalurl' => true,
                'description'  => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'blog'         => [
                    'title'    => 'The awesome blog',
                    'nav'      => [
                        'name'      => 'Blog',
                        'weight'    => 1000,
                    ],
                ],
                'taxonomies'   => [
                    'category',
                ],
                'paginate' => [
                    'max'  => 5,
                    'path' => 'page',
                ],
                'date' => [
                    'format'   => 'j F Y',
                    'timezone' => 'Europe/Paris',
                ],
                'fmpages' => [
                    'robotstxt' => [
                        'layout'    => 'robots.txt',
                        'permalink' => 'robots.txt',
                    ],
                    'sitemap' => [
                        'layout'     => 'sitemap.xml',
                        'permalink'  => 'sitemap.xml',
                        'changefreq' => 'monthly',
                        'priority'   => '0.5',
                    ],
                    '404' => [
                        'layout'    => '404.html',
                        'permalink' => '404.html',
                    ],
                    'rss' => [
                        'layout'    => 'rss.xml',
                        'permalink' => 'rss.xml',
                    ],
                ],
            ],
            'content' => [
                'dir' => 'content',
                'ext' => ['md', 'markdown', 'mdown', 'mkdn', 'mkd', 'text', 'txt'],
            ],
            'frontmatter' => [
                'format' => 'yaml',
            ],
            'body' => [
                'format' => 'md',
            ],
            'static' => [
                'dir' => 'static',
            ],
            'layouts' => [
                'dir'      => 'layouts',
                'internal' => [
                    'redirect.html'      => '',
                    'robots.txt'         => '',
                    'sitemap.xml'        => '',
                    'googleanalytics.js' => 'includes/',
                    'rss.xml'            => '',
                ],
            ],
            'output' => [
                'dir' => 'site',
                'ext' => '.html',
            ],
            'themes' => [
                'dir' => 'themes',
            ],
        ];

        $this->assertSame($defaults, $config->getAllAsArray());
    }
}
