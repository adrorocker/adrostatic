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
use AdroStatic\Util;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use ParsedownExtra;
use Slim\Http\Uri;
use SplFileInfo;
use SplFileObject;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

class AdroStatic
{
    /**
     * @var string
     */
    protected $root;

    /**
     * @var AdroStatic\Container\Container
     */
    protected $container;

    /**
     * @var AdroStatic\AdroStatic
     */
    protected static $instance;

    public static function attic()
    {
        return self::$instance;
    }

    public function __construct($root)
    {
        self::$instance = $this;

        $this->root = $root;
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
        } catch (ParseException $e) {
            $config = [];
        }
        $config = new Config($config);

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
        $uri = Uri::createFromGlobals($_SERVER);
        $files = $this->searchFiles();
        $hash = md5(implode('-', $files));

        if ($this->filesystem->has('map.json')) {
            $mapObject = new SplFileObject(Util::rootPath().'/map.json', 'r+');
            $mapObject->seek(0);
            $contents = trim($mapObject->current());
            $fileHash = str_replace("# Last Source File Hash: ", "", $contents);
            if ($hash === $fileHash) {
                $map = $this->filesystem->read('map.json');
                $map = str_replace("# Last Source File Hash: $hash\n", "", $map);
                $map = json_decode($map, true);
                if (isset($map[$uri->getPath()])) {
                    $page = $this->proccessPage($map[$uri->getPath()]);
                    $query = $uri->getQuery();

                    if (false !== strrpos($query, 'debug')) {
                        $type =  explode('=', $query);
                        $type[1] = isset($type[1])?:'json';
                        switch ($type[1]) {
                            case 'yaml':
                                header('Content-Type: text/yaml');
                                $config = array_merge(Util::config()->get('site'), $page->getAttributes());
                                echo Yaml::dump($config);
                                die();
                                break;
                            
                            default:
                                header('Content-Type: application/json');
                                $config = array_merge(Util::config()->get('site'), $page->getAttributes());
                                echo json_encode($config, JSON_PRETTY_PRINT);
                                die();
                                break;
                        }
                    }
                    echo $page->getContent();
                    die;
                }
            }
        }

        $pages = $this->proccessPages($files);

        $map = $this->buildMap($pages);

        $this->filesystem->put('map.json', "# Last Source File Hash: "."$hash\n".json_encode($map, JSON_PRETTY_PRINT));
    }

    protected function searchFiles()
    {
        $config = container()->get('config')->get('site');
        $contentDir = container()->get('config')->get('content.dir');
        $objects = $this->filesystem->listContents($contentDir, true);
        $files = [];
        foreach ($objects as $object) {
            if ('dir' === $object['type']) {
                continue;
            }
            $files[] = $object['path'];
        }

        return $files;
    }

    protected function proccessPages(array $files)
    {
        $pages = [];
        $posts = [];
        
        foreach ($files as $file) {
            $pages[] = $this->proccessPage($file);
        }

        return $pages;
    }

    protected function proccessPage($file)
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

    protected function buildMap(array $pages)
    {
        $json = [];
        foreach ($pages as $page) {
            $json[$page->getLink()] = $page->getFilePAth();
        }

        return $json;
    }
}
