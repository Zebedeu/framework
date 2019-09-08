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

namespace Ballybran\Helpers\Event;

use Ballybran\Exception;

/**
 * Class Registry
 * @package Ballybran\Helpers\Event
 */
 class Registry
{
    private static $instance;


    /**
     * @var array
     */
    private $method = array();
    private $_object = [];


    /**
     *
     */
    public function doSomething()
    {
        throw new Exception\InvalidCallException("");
    }

    /**
     * @param $name
     * @param $value
     */
    function __set($name , $value)
    {
        $this->_object[$name] = $value;

    }

    /**
     * @param $name
     * @return bool|mixed
     */
    function __get($name)
    {
        if (array_key_exists($name , $this->_object)) {
            return $this->_object[$name];
        }
        return false;
    }

    /**
     * @param $method
     * @param null $param
     * @return mixed
     */

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    /**
     * @param $name
     * @return bool
     */
    public function isValid($name)
    {
        return array_key_exists($name , $this->_object);
    }

    /**
     * @param $name
     * @param $value
     */
    public function set($name , $value)
    {
        $this->_object[$name] = $value;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function get($name)
    {
        if (array_key_exists($name , $this->_object)) {
            return $this->_object[$name];
        }
    }

    /**
     * @param $method
     * @param null $param
     * @return mixed
     */
    public function __call($method , $param = null)
    {
        $prefix = substr($method , 0 , 3);
        $key = strtolower(substr($method , 3));
        if ($prefix == 'set' && count($param) == 1) {

            $value = $param[0];
            $this->method[$key] = $value;

        }
        if ($prefix == 'get' && array_key_exists($key , $this->method)) {
            return $this->method[$key];
        } else {
            throw new  Exception\InvalidCallException ('Setting read-only method: ' . '::');

        }
    }
}

