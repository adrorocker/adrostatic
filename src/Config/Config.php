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

    /**
     * Set source directory.
     *
     * @param null $sourceDir
     *
     * @throws Exception
     *
     * @return $this
     */
    public function setSourceDir($sourceDir = null)
    {
        if ($sourceDir === null) {
            $sourceDir = getcwd();
        }
        if (!is_dir($sourceDir)) {
            throw new \InvalidArgumentException(sprintf("'%s' is not a valid source directory.", $sourceDir));
        }
        $this->sourceDir = $sourceDir;

        return $this;
    }

    /**
     * Get source directory.
     *
     * @return string
     */
    public function getSourceDir()
    {
        return $this->sourceDir;
    }

    /**
     * Set destination directory.
     *
     * @param null $destinationDir
     *
     * @throws Exception
     *
     * @return $this
     */
    public function setDestinationDir($destinationDir = null)
    {
        if ($destinationDir === null) {
            $destinationDir = $this->sourceDir;
        }
        if (!is_dir($destinationDir)) {
            throw new \InvalidArgumentException(sprintf("'%s' is not a valid destination directory.", $destinationDir));
        }
        $this->destinationDir = $destinationDir;

        return $this;
    }

    /**
     * Get destination directory.
     *
     * @return string
     */
    public function getDestinationDir()
    {
        return $this->destinationDir;
    }

    /**
     * Is config has a valid theme?
     *
     * @throws Exception
     *
     * @return bool
     */
    public function hasTheme()
    {
        if ($this->get('theme')) {
            if (!Util::getFS()->exists($this->getThemePath($this->get('theme')))) {
                throw new Exception(sprintf(
                    "Theme directory '%s/%s/layouts' not found!",
                    $this->getThemesPath(),
                    $this->get('theme')
                ));
            }

            return true;
        }

        return false;
    }

    /**
     * Path helpers.
     */

    /**
     * @return string
     */
    public function getContentPath()
    {
        return $this->getSourceDir().'/'.$this->get('content.dir');
    }

    /**
     * @return string
     */
    public function getLayoutsPath()
    {
        return $this->getSourceDir().'/'.$this->get('layouts.dir');
    }

    /**
     * @return string
     */
    public function getThemesPath()
    {
        return $this->getSourceDir().'/'.$this->get('themes.dir');
    }

    /**
     * @param string $theme
     * @param string $dir
     *
     * @return string
     */
    public function getThemePath($theme, $dir = 'layouts')
    {
        return $this->getSourceDir().'/'.$this->get('themes.dir').'/'.$theme.'/'.$dir;
    }

    /**
     * @return string
     */
    public function getOutputPath()
    {
        return $this->getSourceDir().'/'.$this->get('output.dir');
    }

    /**
     * @return string
     */
    public function getStaticPath()
    {
        return $this->getSourceDir().'/'.$this->get('static.dir');
    }
}
