<?php
/**
 * AdroStatic.
 *
 * @link      https://github.com/adrorocker/adrostatic
 *
 * @copyright Copyright 2017 Alejandro Morelos
 */

namespace AdroStatic\Config;

use Dflydev\DotAccessData\Data;

class Config
{
    /**
     * Config.
     *
     * @var Data
     */
    protected $data;

    /**
     * Source directory.
     *
     * @var string
     */
    protected $source;

    /**
     * Destination directory.
     *
     * @var string
     */
    protected $destination;

    /**
     * Default data.
     *
     * @var array
     */
    protected static $defaults = [
        'site' => [
            'title'        => 'Static Site',
            'brand'        => 'AdroStatic',
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

    /**
     * Config constructor.
     *
     * @param Config|array|null $config
     */
    public function __construct($config = null)
    {
        $data = new Data(self::$defaults);
        if ($config instanceof self) {
            $data->importData($config->getAll());
        } elseif (is_array($config)) {
            $data->import($config);
        }
        $this->setFromData($data);
    }

    /**
     * Set config data.
     *
     * @param Data $data
     *
     * @return $this
     */
    protected function setFromData(Data $data)
    {
        if ($this->data !== $data) {
            $this->data = $data;
        }

        return $this;
    }

    /**
     * Get config data.
     *
     * @return Data
     */
    public function getAll()
    {
        return $this->data;
    }

    /**
     * Get data as array.
     *
     * @return array
     */
    public function getAllAsArray()
    {
        return $this->data->export();
    }

    /**
     * Return a config value.
     *
     * @param string $key
     * @param string $default
     *
     * @return array|mixed|null
     */
    public function get($key, $default = '')
    {
        return $this->data->get($key, $default);
    }
}
