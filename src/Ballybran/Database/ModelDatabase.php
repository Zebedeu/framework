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


namespace Ballybran\Database;


class ModelDatabase
{

    private $data = array ();
    private static $table;


    public function __construct($params = null)
    {
        $this->data = $params;

    }
    public function __get($name)
    {
        if(array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }

    }

    public function __set($name, $value)
    {
        $this->data[$name] = $value;

    }


    public function getColumns() {
        return $this->data;
    }


}