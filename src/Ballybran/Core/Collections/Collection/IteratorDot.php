<?php

/**
 * Dot - PHP dot notation access to arrays
 *
 * @author  Riku Särkinen <riku@adbar.io>
 * @link    https://github.com/adbario/php-dot-notation
 * @license https://github.com/adbario/php-dot-notation/blob/2.x/LICENSE.md (MIT License)
 */

namespace Ballybran\Core\Collections\Collection;
use Ballybran\Core\Collections\Collection\ValidateDot;

use ArrayIterator;

/**
 * Dot
 *
 * This class provides a dot notation access and helper functions for
 * working with arrays of data. Inspired by Laravel Collection.
 */
class IteratorDot extends ValidateDot
{
    /**
     * The stored items
     *
     * @var array
     */
    protected $items = [];
    
    /**
     *  elements
     *
     * @var array
     */
    protected $elements;

    /**
     * Create a new Dot instance
     *
     * @param mixed $items
     */
    public function __construct($items = [])
    {
        $this->elements = $this->getArrayItems($items);
    }

    /**
     * Set a given key / value pair or pairs
     * if the key doesn't exist already
     *
     * @param array|int|string $keys
     * @param mixed $value
     */
    public function add($keys, $value = null)
    {
        if (is_array($keys)) {
            foreach ($keys as $key => $value) {
                $this->add($key, $value);
            }
        } elseif (is_null($this->get($keys))) {
            $this->set($keys, $value);
        }
    }

    /**
     * Delete the contents of a given key or keys
     *
     * @param array|int|string|null $keys
     */
    public function clear($keys = null)
    {
        if (is_null($keys)) {
            $this->elements = [];
            return;
        }
        $keys = (array)$keys;
        foreach ($keys as $key) {
            $this->set($key, []);
        }
    }

    /**
     * Delete the given key or keys
     *
     * @param array|int|string $keys
     */
    public function delete($keys)
    {
        $keys = (array)$keys;
        foreach ($keys as $key) {
            if ($this->exists($this->elements, $key)) {
                unset($this->elements[$key]);
                continue;
            }
            $items = &$this->elements;
            $segments = explode('.', $key);
            $lastSegment = array_pop($segments);
            foreach ($segments as $segment) {
                if (!isset($items[$segment]) || !is_array($items[$segment])) {
                    continue 2;
                }
                $items = &$items[$segment];
            }
            unset($items[$lastSegment]);
        }
    }

    /**
     * Flatten an array with the given character as a key delimiter
     *
     * @param  string $delimiter
     * @param  array|null $items
     * @param  string $prepend
     * @return array
     */
    public function flatten($delimiter = '.', $items = null, $prepend = '')
    {
        $flatten = [];
        if (is_null($items)) {
            $items = $this->elements;
        }
        foreach ($items as $key => $value) {
            if (is_array($value) && !empty($value)) {
                $flatten = array_merge(
                    $flatten,
                    $this->flatten($delimiter, $value, $prepend . $key . $delimiter)
                );
            } else {
                $flatten[$prepend . $key] = $value;
            }
        }
        return $flatten;
    }

    /**
     * Return the value of a given key
     *
     * @param  int|string|null $key
     * @param  mixed $default
     * @return mixed
     */
    public function get($key = null, $default = null)
    {
        if (is_null($key)) {
            return $this->elements;
        }
        if ($this->exists($this->elements, $key)) {
            return $this->elements[$key];
        }
        if (false === strpos($key, '.')) {
            return $default;
        }
        $items = $this->elements;
        foreach (explode('.', $key) as $segment) {
            if (!is_array($items) || !$this->exists($items, $segment)) {
                return $default;
            }
            $items = &$items[$segment];
        }
        return $items;
    }

    /**
     * Return the given items as an array
     *
     * @param  mixed $items
     * @return array
     */
    public function getArrayItems($items)
    {
        if (is_array($items)) {
            return $items;
        } elseif ($items instanceof self) {
            return $items->all();
        }
        return (array)$items;
    }

    /**
     * Return the value of a given key and
     * delete the key
     *
     * @param  int|string|null $key
     * @param  mixed $default
     * @return mixed
     */
    public function pull($key = null, $default = null)
    {
        if (is_null($key)) {
            $value = $this->all();
            $this->clear();
            return $value;
        }
        $value = $this->get($key, $default);
        $this->delete($key);
        return $value;
    }

    /**
     * Push a given value to the end of the array
     * in a given key
     *
     * @param mixed $key
     * @param mixed $value
     */
    public function push($key, $value = null)
    {
        if (is_null($value)) {
            $this->elements[] = $key;
            return;
        }
        $items = $this->get($key);
        if (is_array($items) || is_null($items)) {
            $items[] = $value;
            $this->set($key, $items);
        }
    }

   
    /**
     * Return the value of a given key or all the values as JSON
     *
     * @param  mixed $key
     * @param  int $options
     * @return string
     */
    public function toJson($key = null, $options = 0)
    {
        if (is_string($key)) {
            return json_encode($this->get($key), $options);
        }
        $options = $key === null ? 0 : $key;
        return json_encode($this->elements, $options);
    }
        
}