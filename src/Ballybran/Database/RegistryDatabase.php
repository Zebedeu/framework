<?php
/**
 * APWEB Framework (http://framework.artphoweb.com/)
 * APWEB FW(tm) : Rapid Development Framework (http://framework.artphoweb.com/)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @link      http://github.com/zebedeu/artphoweb for the canonical source repository
 * @copyright (c) 2015.  APWEB  Software Technologies AO Inc. (http://www.artphoweb.com)
 * @license   http://framework.artphoweb.com/license/new-bsd New BSD License
 * @author    Marcio Zebedeu - artphoweb@artphoweb.com
 * @version   1.0.0
 */

/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 16/11/17
 * Time: 23:41
 */

namespace Ballybran\Database;



use Prophecy\Exception\Doubler\ClassNotFoundException;

/**
 * Class RegistryDatabase
 * @package Ballybran\Database
 */
class RegistryDatabase extends \ArrayObject
{

    /**
     * @var
     */
    private static $instance;

    /**
     * @var array
     */
    private $element = array();


    /**
     * @param $name
     * @return mixed
     */
    public  function get($name) {
            $instance = self::getInstance();
            if(!$instance->offsetExists($name)){
                throw new \RuntimeException( sprintf( "Class %s Not Found" , $name ) );
            }
            return $instance->offsetGet($name);
    }

    /**
     * @return static
     */
    public static function getInstance() {

        if( self::$instance  == null) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    /**
     * @param $name
     * @param $value
     */
    public function set($name, $value)
    {
        $instance = self::getInstance();
        $instance->offsetSet($name, $value);
    }

    /**
     * @param $name
     * @return bool
     */
    public function isRegistered($name)
    {
        $instance = self::getInstance();
        return $instance->offsetExists($name);
    }

    /**
     * @param $name
     */
    public function unRegistered($name)
    {
        $instance = self::getInstance();
         $instance->offsetUnset($name);
    }

    /**
     * RegistryDatabase constructor.
     * @param array $input
     * @param int $flags
     * @param string $iterator_class
     */
    public function __construct($input = [], $flags = 0, $iterator_class = "ArrayIterator")
    {
        parent::__construct($input, $flags);
    }

}