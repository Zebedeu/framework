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
 * User: artphotografie
 * Date: 15/11/17
 * Time: 14:16
 */

namespace Ballybran\Helpers\Event;


use function array_key_exists;
use const false;

class Registry
{
    private $_store = array();
    static $instance = array();

    public static function getInstance()
    {
        if(self::$instance == null) {
            self::$instance = new Registry();
        }

        return self::$instance;
    }

    public function get( $key )
    {
            if(array_key_exists($key, $this->_store)) {
                return $this->_store[$key];
            }
    }

    public function set($key, $obj  )
    {
        $this->_store[$key] = $obj;
    }

    public function isValid( $key )
    {
        return array_key_exists($key, $this->_store);
    }
}