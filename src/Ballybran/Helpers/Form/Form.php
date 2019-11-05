<?php

/**
 * KNUT7 K7F (https://marciozebedeu.com/)
 * KNUT7 K7F (tm) : Rapid Development Framework (https://marciozebedeu.com/)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @link      https://github.com/knut7/framework/ for the canonical source repository
 * @copyright (c) 2015.  KNUT7  Software Technologies AO Inc. (https://marciozebedeu.com/)
 * @license   https://marciozebedeu.com/license/new-bsd New BSD License
 * @author    Marcio Zebedeu - artphoweb@artphoweb.com
 * @version   1.0.2
 */

namespace Ballybran\Helpers\Form;

class Form extends Value
{


    /** @var array $_currentItem The immediately posted item */
    private $_currentItem = null;

    /** @var array $_postData Stores the Posted Data */
    private $_postData = array("text" => "text", "button" => "button");


    private $_name;
    private $_value;
    public $_va;

    function __construct()
    {
        parent::__construct();
        $this->_va = new Value();
    }

    public function setMethod($string)
    {
        $this->s_method = $string;
        return $this;
    }

    public function setType($field, $nome = null, $value = null)
    {

        $this->_postData[$field] = $field;
        $this->_currentItem = $field;
        $this->_name = $nome;
        $this->_value = $value;
        return $this;

    }

    public function getType()
    {
        $this->_postData;
        $this->_currentItem;
        $this->_name;
        $this->_value;
        return $this;

    }

    /**
     * @return
     */
    public function show()
    {
        echo "<input type='" . $this->_currentItem . "' name='" . $this->_name . "'  placeholder='" . $this->_value . "' />";

        return $this;
    }

    public function textarea()
    {
        echo "<textarea name='" . $this->_name . "'  value='" . $this->_value . "'></textarea>";

        return $this;
    }

    public function select()
    {
        ?>
        <select name="quantidade" id="">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>

        <?php
        return $this;
    }


}

