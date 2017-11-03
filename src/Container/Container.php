<?php
/**
 * AdroStatic
 *
 * @link      https://github.com/adrorocker/adrostatic
 * @copyright Copyright (c) 2017 Alejandro Morelos
 */

namespace AdroStatic\Container;

use Pimple\Container as Pimple;

class Container extends Pimple
{
    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return mixed Entry.
     */
    public function get($id, $default = null)
    {
        if (!$this->has($id)) {
            return $default;
        }
        return $this->offsetGet($id);
    }

    /**
     * Returns true if the container can return an entry for the given identifier.
     * Returns false otherwise.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return boolean
     */
    public function has($id)
    {
        return $this->offsetExists($id);
    }

    public function __get($name)
    {
        return $this->get($name);
    }

    public function __isset($name)
    {
        return $this->has($name);
    }
}
