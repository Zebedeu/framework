<?php
/**
 * Created by PhpStorm.
 * User: artphotografie
 * Date: 24/09/17
 * Time: 22:09
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