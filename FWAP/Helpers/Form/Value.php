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
 * Copyright (c) 2017.  APWEB  Software Technologies AO Inc. (http://www.artphoweb.com)
 * @license   http://framework.artphoweb.com/license/new-bsd New BSD License
 * @author    Marcio Zebedeu - artphoweb@artphoweb.com
 * @version   1.0.0
 */

namespace FWAP\Helpers\Form;

use FWAP\Helpers\Security\Validate;

class Value
{

    private $_value;
    private $_post;
    private $_teste;

    function __construct()
    {
         $this->_teste = new ClassHtml();


    }

    public function value($string){

         $this->_value = $string;
        return $this;
    }
    public function getValue(){

        echo  "value=".$this->_value.">";
        return $this;
    }

    public function openForm($action, $method = "get")
    {
        echo "<form action=" .$action ."  enctype='multipart/form-data' method='". $method ."' >";
        return $this;
    }

    public function closeForm()
    {
        echo "</form>" ;

    }



}