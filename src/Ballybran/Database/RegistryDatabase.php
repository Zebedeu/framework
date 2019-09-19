<?php
/**
 * KNUT7 K7F (http://framework.artphoweb.com/)
 * KNUT7 K7F (tm) : Rapid Development Framework (http://framework.artphoweb.com/).
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @see      http://github.com/zebedeu/artphoweb for the canonical source repository
 *
 * @copyright (c) 2015.  KNUT7  Software Technologies AO Inc. (http://www.artphoweb.com)
 * @license   http://framework.artphoweb.com/license/new-bsd New BSD License
 * @author    Marcio Zebedeu - artphoweb@artphoweb.com
 *
 * @version   1.0.2
 */

namespace Ballybran\Database;

/**
 * Class RegistryDatabase.
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
     *
     * @return mixed
     */
    public function get($name)
    {
        $instance = self::getInstance();
        if (!$instance->offsetExists($name)) {
            throw new \RuntimeException(sprintf('Class %s Not Found', $name));
        }

        return $instance->offsetGet($name);
    }

    /**
     * @return static
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
     * @param $value
     */
    public function set($name, $value)
    {
        $instance = self::getInstance();
        $instance->offsetSet($name, $value);
    }

    /**
     * @param $name
     *
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
     *
     * @param array $input
     * @param int $flags
     * @param string $iterator_class
     */
    public function __construct($input = [], $flags = 0, $iterator_class = 'ArrayIterator')
    {
        parent::__construct($input, $flags);
    }
}
