<?php
/**
 * AdroStatic.
 *
 * @copyright Copyright (c) 2017 Alejandro Morelos
 *
 * @link      https://github.com/adrorocker/adrostatic
 */

namespace AdroStatic;

use AdroStatic\Content\Page\AbstractPage;
use League\Flysystem\Filesystem;
use Slim\Http\Uri;
use SplFileObject;
use Symfony\Component\Yaml\Yaml;

class Util
{
    public static function __callStatic($name, $arguments)
    {
        if (container()->has($name)) {
            return container()->get($name);
        }
    }

    public static function mapExist()
    {
        return self::filesystem()->has('map.json');
    }

    public static function mapHashFromFiles(array $files)
    {
        return md5(implode('-', $files));
    }

    public static function getMapHash()
    {
        $mapObject = new SplFileObject(self::rootPath().'/map.json', 'r+');
        $mapObject->seek(0);
        $contents = trim($mapObject->current());

        return str_replace('# Last Source File Hash: ', '', $contents);
    }

    public static function getMap()
    {
        $hash = self::getMapHash();
        $map = self::filesystem()->read('map.json');
        $map = str_replace("# Last Source File Hash: $hash\n", '', $map);

        return json_decode($map, true);
    }

    public static function buildMap(array $pages)
    {
        $json = [];
        foreach ($pages as $page) {
            $link = $page->getLink();
            if (endsWith($link, '/')) {
                $link = $link.'index';
            }
            if ($page->getFilePath() == null) {
                // code...
            }
            $json[$page->getLink()] = $page->getFilePath();
        }

        return $json;
    }

    public static function debug(Uri $uri, AbstractPage $page)
    {
        $query = $uri->getQuery();

        if (false !== strrpos($query, 'debug')) {
            $type = explode('=', $query);
            $type[1] = isset($type[1]) ?: 'json';
            switch ($type[1]) {
                case 'yaml':
                    header('Content-Type: text/yaml');
                    $config = array_merge(self::config()->get('site'), $page->getAttributes());
                    echo Yaml::dump($config);
                    break;

                default:
                    header('Content-Type: application/json');
                    $config = array_merge(self::config()->get('site'), $page->getAttributes());
                    echo json_encode($config, JSON_PRETTY_PRINT);
                    break;
            }

            return true;
        }

        return false;
    }
}
