<?php

/**
 * Dot - PHP dot notation access to arrays
 *
 * @author  Riku Särkinen <riku@adbar.io>
 * @link    https://github.com/adbario/php-dot-notation
 * @license https://github.com/adbario/php-dot-notation/blob/2.x/LICENSE.md (MIT License)
 */

namespace Ballybran\Core\Collections\Collection;

use Countable;
use ArrayIterator;

/**
 * Dot
 *
 * This class provides a dot notation access and helper functions for
 * working with arrays of data. Inspired by Laravel Collection.
 */
class ValidateDot implements Countable
{
   
    /**
     * Replace all items with a given array as a reference
     *
     * @param array $items
     */
    public function setReference(array &$items)
    {
        $this->elements = &$items;
    }

	/**
     * Return all the stored items
     *
     * @return array
     */
    public function all()
    {
        return $this->elements;
    }


    /**
     * Checks if the given key exists in the provided array.
     *
     * @param  array $array Array to validate
     * @param  int|string $key The key to look for
     *
     * @return bool
     */
    private function exists($array, $key)
    {
        return array_key_exists($key, $array);
    }

   
      /*
     * --------------------------------------------------------------
     * ArrayAccess interface
     * --------------------------------------------------------------
     */
    /**
     * Check if a given key exists
     *
     * @param  int|string $key
     * @return bool
     */
    public function offsetExists($key)
    {
        return $this->has($key);
    }

    /**
     * Replace all items with a given array
     *
     * @param mixed $items
     */
    public function setArray($items)
    {
        $this->elements = $this->getArrayItems($items);
    }

    /*
     * --------------------------------------------------------------
     * Countable interface
     * --------------------------------------------------------------
     */
    /**
     * Return the number of items in a given key
     *
     * @param  int|string|null $key
     * @return int
     */
    public function count($key = null)
    {
        return count($this->get($key));
    }


}