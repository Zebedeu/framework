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
    protected function exists($array, $key)
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


    /**
     * Check if a given key or keys exists
     *
     * @param  array|int|string $keys
     * @return bool
     */
    public function has($keys)
    {
        $keys = (array)$keys;
        if (empty($this->elements) || $keys === []) {
            return false;
        }
        foreach ($keys as $key) {
            $items = $this->elements;
            if ($this->exists($items, $key)) {
                continue;
            }
            foreach (explode('.', $key) as $segment) {
                if (!is_array($items) || !$this->exists($items, $segment)) {
                    return false;
                }
                $items = $items[$segment];
            }
        }
        return true;
    }
 	
        /**
         * Set a given key / value pair or pairs
         *
         * @param array|int|string $keys
         * @param mixed $value
         */
    public function set($keys, $value = null)
    {
        if (is_array($keys)) {
            foreach ($keys as $key => $value) {
                $this->set($key, $value);
            }
            return;
        }
        $items = &$this->elements;
        foreach (explode('.', $keys) as $key) {
            if (!isset($items[$key]) || !is_array($items[$key])) {
                $items[$key] = [];
            }
            $items = &$items[$key];
        }
        $items = $value;
    }

    /**
     * Check if a given key or keys are empty
     *
     * @param  array|int|string|null $keys
     * @return bool
     */
    public function isEmpty($keys = null)
    {
        if (is_null($keys)) {
            return empty($this->elements);
        }
        $keys = (array)$keys;
        foreach ($keys as $key) {
            if (!empty($this->get($key))) {
                return false;
            }
        }
        return true;
    }

    /**
     * Merge a given array or a Dot object with the given key
     * or with the whole Dot object
     *
     * @param array|string|self $key
     * @param array $value
     */
    public function merge($key, $value = null)
    {
        if (is_array( $key )) {
            $this->elements = array_merge( $this->elements , $key );
        }
        if (is_string( $key )) {
            $items = (array)$this->get( $key );
            $value = array_merge( $items , $this->getArrayItems( $value ) );
            $this->set( $key , $value );
        }
        if (is_object( $key ) || $key instanceof IteratorDot) {
            $this->elements = array_merge( $this->elements , $key->all() );
        }
    }
}