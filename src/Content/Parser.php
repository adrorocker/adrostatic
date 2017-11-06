<?php
/**
 * AdroStatic.
 *
 * @copyright Copyright (c) 2017 Alejandro Morelos
 *
 * @link      https://github.com/adrorocker/adrostatic
 */

namespace AdroStatic\Content;

use AdroStatic\Util;
use SplFileInfo;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class Parser
{
    const PATTERN = '^\s*(?:<!--|---|\+++){1}[\n\r\s]*(.*?)[\n\r\s]*(?:-->|---|\+++){1}[\s\n\r]*(.*)$';

    /**
     * @var SplFileInfo
     */
    protected $file;

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @var string
     */
    protected $body;

    /**
     * Constructor.
     *
     * @param SplFileInfo $file
     */
    public function __construct(SplFileInfo $file)
    {
        $this->file = $file;
    }

    /**
     * Parse the contents of the file.
     *
     * @throws \RuntimeException
     *
     * @return $this
     */
    public function parse()
    {
        preg_match(
            '/'.self::PATTERN.'/s',
            Util::filesystem()->read($this->file->getPathName()),
            $matches
        );

        if (!$matches) {
            $this->body = Util::filesystem()->read($this->file->getPathName());

            return $this;
        }

        try {
            $this->attributes = Yaml::parse($matches[1]);
        } catch (ParseException $e) {
        }

        $this->body = trim($matches[2]);

        return $this;
    }

    /**
     * Get attributes.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Get body.
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Get file path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->file->getPathName();
    }
}
