<?php

/**
 * KNUT7 K7F (https://marciozebedeu.com/)
 * KNUT7 K7F (tm) : Rapid Development Framework (https://marciozebedeu.com/).
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @see      https://github.com/knut7/framework/ for the canonical source repository
 *
 * @copyright (c) 2015.  KNUT7  Software Technologies AO Inc. (https://marciozebedeu.com/)
 * @license   https://marciozebedeu.com/license/new-bsd New BSD License
 * @author    Marcio Zebedeu - artphoweb@artphoweb.com
 *
 * @version   1.0.2
 */

namespace Ballybran\Helpers\Security;

use Ballybran\Core\Collections\Collection\IteratorCollection;
use Ballybran\Helpers\Utility\HashInterface;

/**
 * Class Validate.
 */
class Validate
{
    /** @var array $_currentItem The immediately posted item */
    private $_currentItem = null;

    /** @var array $_postData Stores the Posted Data */
    private $_postData = array();

    /** @var object $_val The validator object */
    private $_val = array();

    /** @var array $_error Holds the current forms errors */
    private $_error = array();

    /** @var string $_method The Method POST, GET and PUT for form */
    private $_method;

    /**
     * __construct - Instantiates the validator class.
     */
    public function __construct($validationFields = null)
    {
        if (is_null($validationFields)) {
            $this->_val = $validationFields = new Val();
        }
        $this->_val = $validationFields;
    }

    public function getMethod()
    {
        return $this->_method;
    }

    public function setMethod($method)
    {
        $this->_method = $method;

        return $this;
    }

    public function post($field)
    {
        if ($this->_method == 'POST') {
            $this->_postData[$field] = $_POST[$field];
            $this->_currentItem = $field;
        }

        if ($this->_method == 'GET') {
            $this->_postData[$field] = $_GET[$field];
            $this->_currentItem = $field;
        }

        if ($this->_method == 'COOKIE') {
            $this->_postData[$field] = $_COOKIE[$field];
            $this->_currentItem = $field;
        }

        return $this;
    }

    public function any($field)
    {
        $req_method = strtolower($_SERVER['REQUEST_METHOD']);

        if ($req_method == true) {
            $this->_postData[$field] = $req_method[$field];
            $this->_currentItem = $field;
        }

        return $this;
    }

    public function getPostDataForHash($fieldName = null, HashInterface $hashObject = null)
    {
        $it = new IteratorCollection($this->_postData);
        if (isset($fieldName) && is_object($hashObject)) {
            if (isset($this->_postData[$fieldName])) {
                $this->_postData[$this->_currentItem];

                $securityHash = $hashObject::hash_password($this->_postData[$fieldName]);
                $it->set($fieldName, $securityHash);
            }

            return $it->toArray();
        }

        return $this->_postData;
    }

    public function getPostData($fieldName = false)
    {
        if ($fieldName == false) {
            return $this->_postData;
        }
        if ($this->submit() == true) {
            if ($fieldName && isset($this->_postData[$fieldName])) {
                return $this->_postData[$fieldName];
            }

            return false;
        }
    }

    /**
     * @param string $typeOfValidator |maxlength|minlength|digit|isValidLenght
     * @param int $arg
     *
     * @return $this
     */
    public function val(string $typeOfValidator, int $length)
    {
        $error = '';

        if (!empty($length)) {
            $error = $this->_val->{$typeOfValidator}($this->_postData[$this->_currentItem], $length);
        }
        if ($error) {
            $this->_error[$this->_currentItem] = $error;
        }

        return $this;
    }

    public function text()
    {
        if (!is_string($this->_postData[$this->_currentItem])) {
            throw new \InvalidArgumentException('the value ('.$this->_postData[$this->_currentItem].') entered must have a Text');
        }

        return $this;
    }

    public function email()
    {
        $email = filter_var($this->_postData[$this->_currentItem], FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('the value ('.$this->_postData[$this->_currentItem].') entered must have a Email');
        }

        return $this;
    }

    public function numeric()
    {
        if (!is_numeric($this->_postData[$this->_currentItem])) {
            throw new \InvalidArgumentException('the value ('.$this->_postData[$this->_currentItem].') entered must have a Numeric');
        }

        return $this;
    }

    public function int()
    {
        if (!intval($this->_postData[$this->_currentItem])) {
            throw new \InvalidArgumentException('the value ('.$this->_postData[$this->_currentItem].') entered must have a Int');
        }

        return $this;
    }

    public function long()
    {
        if (!floatval($this->_postData[$this->_currentItem])) {
            throw new \InvalidArgumentException('the value ('.$this->_postData[$this->_currentItem].') entered must have a Long');
        }

        return $this;
    }

    public function domain()
    {
        if (!filter_var($this->_postData[$this->_currentItem], FILTER_VALIDATE_DOMAIN)) {
            throw new \InvalidArgumentException('the value ('.$this->_postData[$this->_currentItem].') entered must have a Domain');
        }

        return $this;
    }

    public function url()
    {
        if (!filter_var($this->_postData[$this->_currentItem], FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException('the value ('.$this->_postData[$this->_currentItem].') entered must have a Url');
        }

        return $this;
    }

    public function ip()
    {
        if (!filter_var($this->_postData[$this->_currentItem], FILTER_VALIDATE_IP)) {
            throw new \InvalidArgumentException('the value ('.$this->_postData[$this->_currentItem].') entered must have a Ip');
        }

        return $this;
    }

    public function date()
    {
        if (!is_string($this->_postData[$this->_currentItem])) {
            throw new \InvalidArgumentException('the value ('.$this->_postData[$this->_currentItem].') entered must have a Date');
        }

        return $this;
    }

    public function submit()
    {
        if (empty($this->_error)) {
            return true;
        }

        $str = '';
        foreach ($this->_error as $key => $value) {
            $str .= $key . ' => ' . $value . "\n" . '<br>';
        }
        echo "Error Processing Request $str";

        return false;
    }
}
