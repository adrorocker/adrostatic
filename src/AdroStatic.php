<?php
/**
 * AdroStatic.
 *
 * @copyright Copyright (c) 2017 Alejandro Morelos
 *
 * @link      https://github.com/adrorocker/adrostatic
 */

namespace AdroStatic;

use AdroStatic\Config\Config;
use AdroStatic\Container\Container;
use AdroStatic\Content\Page;
use AdroStatic\Content\Parser;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use ParsedownExtra;
use Slim\Http\Uri;
use SplFileInfo;
use Symfony\Component\Yaml\Yaml;

class AdroStatic
{
    /**
     * @var string
     */
    protected $root;

    /**
     * @var array
     */
    protected $files = [];

    /**
     * @var array
     */
    protected $pages = [];

    /**
     * @var array
     */
    protected $posts = [];

    /**
     * @var array
     */
    protected $taxonomies = [
        'category' => [],
    ];

    /**
     * @var AdroStatic\Container\Container
     */
    protected $container;

    /**
     * @var AdroStatic\Config\Config
     */
    protected $config;

    /**
     * @var AdroStatic\AdroStatic
     */
    protected static $instance;

    public static function attic()
    {
        return self::$instance;
    }

    public function __construct($root, Config $config = null)
    {
        self::$instance = $this;

        $this->root = $root;
        $this->config = $config;
        $this->container = new Container();
        $this->boostrap();
    }

    public function getContainer()
    {
        return $this->container;
    }

    protected function boostrap()
    {
        try {
            $config = Yaml::parse(file_get_contents($this->root.'/static.yml'));
        } catch (\Exception $e) {
            $config = [];
        }
        if ($this->config) {
            $config = $this->config;
        } else {
            $config = new Config($config);
        }

        $this->container['config'] = function ($container) use ($config) {
            return $config;
        };

        $root = $this->root;

        $this->container['rootPath'] = function ($container) use ($root) {
            return $root;
        };

        $this->filesystem = $filesystem = new Filesystem(new Local($this->root));

        $this->container['filesystem'] = function ($container) use ($filesystem) {
            return $filesystem;
        };
    }

    public static function factory($path)
    {
        return new self($path);
    }

    public function get($property = null, $default = null)
    {
        if (isset($this->container->$property)) {
            return $this->container->$property;
        }

        return $default;
    }

    public function proxy()
    {
        $this->build();

        $link = Uri::createFromGlobals($_SERVER)->getPath();

        $outpurDir = container()->get('config')->get('output.dir');
        $link = $outpurDir.$link;
        if (endsWith($link, '/')) {
            $ext = container()->get('config')->get('output.ext');
            $link = $link.'index'.$ext;
        }

        $dir = Util::config()->get('themes.dir');
        $path = Util::rootPath().'/'.$dir;
        $src = $path.'/'.Util::config()->get('theme').'/static/';
        $dest = Util::rootPath().'/public/';

        recurse_copy($src, $dest);

        echo Util::filesystem()->read($link);
    }

    public function build()
    {
        $files = $this->searchFiles();
        $pages = $this->createPages($files);
        $posts = $this->getPosts();
        $taxonomies = $this->classifyPosts();
        $this->createBlog();

        $this->generate();
    }

    protected function getPosts()
    {
        foreach ($this->pages as $page) {
            if ($page instanceof Page\Post) {
                $this->posts[] = $page;
            }
        }

        return $this->posts;
    }

    protected function classifyPosts()
    {
        $taxonomies = Util::config()->get('site.taxonomies');

        foreach ($this->posts as $post) {
            $attributes = $post->getAttributes();
            foreach ($taxonomies as $taxonomy) {
                if (array_key_exists($taxonomy, $attributes)) {
                    $this->taxonomies[$taxonomy][$attributes[$taxonomy]][] = $post;
                }
            }
        }

        return $this->taxonomies;
    }

    protected function createBlog()
    {
        $config = container()->get('config')->get('site');
        $attributes = container()->get('config')->get('site.blog');
        $renderer = (new Renderer\Blog())->setCategories($this->taxonomies['category'])->setPosts($this->posts);
        $categories = $renderer->renderCategories($config);
        $content = $renderer->renderContent($categories, $config);
        $blog = new Page\Blog($content, $attributes);
        $this->pages[] = $blog;

        foreach ($this->taxonomies['category'] as $category => $posts) {
            $content = $renderer->setPosts($posts)->renderContent($categories, $config);
            $this->pages[] = new Page\Category($category, $content, $attributes);
        }
    }

    protected function respond(Page\AbstractPage $page)
    {
        $link = $page->getLink();
        if (endsWith($link, '/')) {
            $link = $link.'index';
        }
        $ext = container()->get('config')->get('output.ext');
        $outpurDir = container()->get('config')->get('output.dir');
        $link = $outpurDir.'/'.$link.$ext;
        echo Util::filesystem()->read($link);
    }

    protected function searchFiles()
    {
        $contentDir = container()->get('config')->get('content.dir');
        $objects = $this->filesystem->listContents($contentDir, true);
        $files = [];
        foreach ($objects as $object) {
            if ('dir' === $object['type']) {
                continue;
            }
            $files[] = $object['path'];
        }

        $this->files = $files;

        return $files;
    }

    protected function createPages(array $files)
    {
        $pages = [];

        foreach ($files as $file) {
            $page = $this->createPage($file);
            $pages[] = $page;
        }

        $this->pages = $pages;

        return $pages;
    }

    protected function createPage($file)
    {
        $body = '';
        $parser = new Parser(
            new SplFileInfo($file)
        );
        $parser->parse();
        $body = ParsedownExtra::instance()->text($parser->getBody());
        $attributes = $parser->getAttributes();
        $filePath = $parser->getPath();
        $fileName = trim(str_replace(container()->get('config')->get('content.dir'), '', $file), '/');

        if (preg_match('/^index.(md|html)/i', $fileName)) {
            $page = new Page\Home($body, $attributes, $filePath);
        } elseif (isset($attributes['type']) && $attributes['type'] === 'post') {
            $page = new Page\Post($body, $attributes, $filePath);
        } else {
            $page = new Page\Page($body, $attributes, $filePath);
        }

        return $page;
    }

    protected function generate()
    {
        $posts = [];
        $config = container()->get('config')->get('site');
        $menu = Renderer\Navigation::build($this->pages)->render($config);
        $ext = container()->get('config')->get('output.ext');
        $outpurDir = container()->get('config')->get('output.dir');
        foreach ($this->pages as $page) {
            $noExt = false;
            if ($page instanceof Page\Home) {
                $config = array_merge($config, $page->getAttributes());
                $content = (new Renderer\Home())->setMenu($menu)->render($page->getContent(), $config);
            } elseif ($page instanceof Page\Post) {
                $noExt = true;
                $config = array_merge($config, $page->getAttributes());
                $content = (new Renderer\Post())->setCategories($this->taxonomies['category'])
                    ->renderCategories($config)
                    ->setMenu($menu)
                    ->render($page->getContent(), $config);
            } elseif ($page instanceof Page\Page) {
                $config = array_merge($config, $page->getAttributes());
                $content = (new Renderer\Page())->setMenu($menu)->render($page->getContent(), $config);
            } elseif ($page instanceof Page\Blog) {
                $config = array_merge($config, $page->getAttributes());
                $content = (new Renderer\Blog())->setMenu($menu)->render($page->getContent(), $config);
            } elseif ($page instanceof Page\Category) {
                $config = array_merge($config, $page->getAttributes());
                $content = (new Renderer\Blog())->setMenu($menu)->render($page->getContent(), $config);
            }

            $link = $page->getLink();
            if (endsWith($link, '/')) {
                $link = $link.'index';
            }

            $link = $outpurDir.$link;
            if (!$noExt) {
                $link .= $ext;
            }
            $noExt = false;
            Util::filesystem()->put($link, $content);
        }

        $dir = Util::config()->get('themes.dir');
        $path = Util::rootPath().'/'.$dir;
        $src = $path.'/'.Util::config()->get('theme').'/static/';
        $dest = Util::rootPath().'/'.$outpurDir.'/';

        recurse_copy($src, $dest);
    }
}
