<?php

/**
 * KNUT7 K7F (http://framework.artphoweb.com/)
 * KNUT7 K7F (tm) : Rapid Development Framework (http://framework.artphoweb.com/)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @link      http://github.com/zebedeu/artphoweb for the canonical source repository
 * @copyright (c) 2015.  KNUT7  Software Technologies AO Inc. (http://www.artphoweb.com)
 * @license   http://framework.artphoweb.com/license/new-bsd New BSD License
 * @author    Marcio Zebedeu - artphoweb@artphoweb.com
 * @version   1.0.2
 */

namespace Ballybran\Core\Collections\Collection;



use Ballybran\Core\Variables\Variable;
use Closure;
use Phpml\Exception\InvalidArgumentException;

/**
 * Class IteratorCollection
 * @package Ballybran\Core\Collections\Collection
 */
class IteratorCollection extends Variable implements \ArrayAccess {

    /**
     * @var array
     */
    private $elements;
    /**
     * @var int
     */
    private $position = 0;

    //put your code here

    /**
     * IteratorCollection constructor.
     * @param array $elements
     */
    public function __construct(array $elements = array() ) {

        parent::__construct($elements);

        $this->elements = $elements;
    }
    protected function setElementsFromTrustedSource(array $elements)
    {
        $this->elements = $elements;
    }


    /**
     * @return array
     */
    public function toArray() : array {
        return $this->elements;
    }

    /**
     * @return \ArrayObject
     */
    public function getIterator() {

        return new \ArrayObject($this->elements);
    }

    public function count() {
        return count($this->elements);
    }

    public function current() {
        return current($this->elements);
    }

    public function contains($element) {
        return in_array($element, $this->elements, true);
    }

    /**
     * @return mixed
     */
    public function next() {
        return next($this->elements);
    }

    public function last() {
        return end($this->elements);
    }

    public function first() {
        return reset($this->elements);
    }

    public function key() {
        return key($this->elements);
    }

    public function valid() {
        // return isset($this->elements[$this->position]);
        return $this->offsetExists($this->elements);

    }

    public function offsetGet($offset) {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value) {
        if (!isset($offset)) {
            return $this->set($offset, $value);
        }
        return $this->set($offset, $value);
    }

    public function offsetUnset($offset) {
        return $this->remove($offset);
    }

    public function containsKey($key) {
        return isset($this->elements[$key]) || array_key_exists($key, $this->elements);
    }

    public function offsetExists($offset) {
        return $this->containsKey($offset);
    }

    public function remove($key) : string {
        if (!isset($this->elements[$key]) && !array_key_exists($key, $this->elements)) {
            return null;
        } else {
            $removed = $this->elements[$key];
            unset($this->elements[$key]);

            return $removed;
        }
    }

    public function removeEleme($element) {
        $key = array_search($element, $this->elements, true);
        if ($key == false) {
            return false;
        }
        unset($this->elements[$key]);
        return true;
    }

    public function add($value) {
        $this->elements[] = $value;

        return $this;
    }

    public function set($key, $value) {
        $this->elements[$key] = $value;

        return true;
    }

    public function ksort() {

        return ksort($this->elements);
    }

    public function natSort() {
        return natsort($this->elements);
    }

    public function natcasesort() {
        return natcasesort($this->elements);
    }

    public function exists(Closure $p) {
        foreach ($this->elements as $key => $element) {
            if ($p($key, $element)) {
                return true;
            }
        }
        return false;
    }

    /**
    *@return int
    * return the position of the  element
    */
    public function indexOf($element): Int {
        return array_search($element, $this->elements);
    }

    public function isEmpty() {
        return empty($this->elements);
    }

    public function getValues() {

        return array_values($this->elements);
    }

    public function getKey() {
        return array_keys($this->elements);
    }

    public function get($key) {
        return isset($this->elements[$key]) ? $this->elements[$key] : null;
    }


    public function slice($start, $end)
    {
        if($start < 0 || !is_int($start)) {
            throw new InvalidArgumentException("Start must be a no-negative integer");
        }

        if($end < 0 || !is_int($end)) {
            throw new InvalidArgumentException("End must be a positive integer");
        }

        if($start  > $end ) {
            throw new InvalidArgumentException("End must be geater than start");
        }

        if($end  > $this->count() + 1 ) {
            throw new InvalidArgumentException("End must be less than the count of the items in the Collection");
        }

        $length = $end - $start + 1;

        $subsetItems = array_slice($this->elements, $start, $length);


        return $this->setElementsFromTrustedSource($subsetItems);

    }

    public function reverse()
    {

        $item =  array_reverse($this->elements);
        return $this->setElementsFromTrustedSource($item);

    }

}
