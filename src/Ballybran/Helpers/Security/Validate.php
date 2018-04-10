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

namespace Ballybran\Helpers\Security;


use Ballybran\Exception\Exception;

/**
 * Class Validate
 * @package Ballybran\Helpers\Security
 */
class Validate
{


    /** @var array $_currentItem The immediately posted item */
    private $_currentItem = null;

    /** @var array $_postData Stores the Posted Data */
    private $_postData = array ();

    /** @var object $_val The validator object */
    private $_val = array ();

    /** @var array $_error Holds the current forms errors */
    private $_error = array ();

    /** @var string $_method The Method POST, GET and PUT for form */
    private $_method;


    /**
     * __construct - Instantiates the validator class
     *
     */
    public function __construct($validationFields)
    {

       if(! is_object($validationFields)){
           throw new \InvalidArgumentException("past argument is not an instance");
       }
           $this->_val = $validationFields;


    }

    public function getMethod()
    {
        return  $this->_method;
    }


    public function setMethod($method)
    {
        $this->_method = $method;
        return $this;
    }


    public function post($field)
    {

        if ($this->_method == "POST") {

            $this->_postData[$field] = $_POST[$field];
            $this->_currentItem = $field;

        }

        if ($this->_method == "GET") {

            $this->_postData[$field] = $_GET[$field];
            $this->_currentItem = $field;
        }

        if ($this->_method == "COOKIE") {

            $this->_postData[$field] = $_COOKIE[$field];
            $this->_currentItem = $field;
        }
        return $this;
    }


    public function getPostData($fieldName = false)
    {

        if ($fieldName)
        {
            if (isset($this->_postData[$fieldName]))
                return $this->_postData[$fieldName];


            else
                return false;
        }
        else
        {

            return $this->_postData;
        }

    }


    public function val($typeOfValidator, $arg = null)
    {

        if (! $arg == null )
            $error = $this->_val->{$typeOfValidator}($this->_postData[$this->_currentItem], $arg);
        else
        $error = $this->_val->{$typeOfValidator}($this->_postData[$this->_currentItem]);

        if ($error)
             $this->_error[$this->_currentItem] = $error;

        return $this;
    }


    public function string()
    {
        if(!is_string($this->_postData[$this->_currentItem])){
            throw new \InvalidArgumentException("the value entered must have a String");
        }
        return $this;
    }
    public function email()
    {
        $email = filter_var($this->_postData[$this->_currentItem], FILTER_SANITIZE_EMAIL);
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            throw new \InvalidArgumentException("the value entered must have a Email");
        }

        return $this;
    }
    public function numeric()
    {
        if(!is_numeric($this->_postData[$this->_currentItem])){
            throw new \InvalidArgumentException("the value entered must have a Numeric");
        }
        return $this;
    }
    public function int()
    {
        if(!is_int($this->_postData[$this->_currentItem])){
            throw new \InvalidArgumentException("the value entered must have a Int");
        }
        return $this;
    }

    public function long()
    {
        if(!is_long($this->_postData[$this->_currentItem])){
            throw new \InvalidArgumentException("the value entered must have a Long");
        }

        return $this;
    }

    public function domain()
    {
        if(!filter_var($this->_postData[$this->_currentItem], FILTER_VALIDATE_DOMAIN)){
            throw new \InvalidArgumentException("the value entered must have a Domain");
        }

        return $this;
    }

    public function url()
    {
        if(!filter_var($this->_postData[$this->_currentItem], FILTER_VALIDATE_URL)){
            throw new \InvalidArgumentException("the value entered must have a Url");
        }
        return $this;
    }


    public function ip()
    {
        if(!filter_var($this->_postData[$this->_currentItem], FILTER_VALIDATE_IP)){
            throw new \InvalidArgumentException("the value entered must have a Ip");
        }
        return $this;
    }

    public function date()
    {

        if(!is_string($this->_postData[$this->_currentItem])){
            throw new \InvalidArgumentException("the value entered must have a Date");
        }
        return $this;
    }

    public function submit()
    {
        if (empty($this->_error))
        {
            return true;
        }

            $str = '';
            foreach ($this->_error as $key => $value)
            {
                $str .= $key . ' => ' . $value . "\n" . "<br>";
            }

            echo ("Error Processing Request $str");
    }

}
