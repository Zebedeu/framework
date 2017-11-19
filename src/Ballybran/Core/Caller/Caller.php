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


namespace Ballybran\Core\Caller;

use Ballybran\Helpers\vardump\Vardump;
use function str_replace;

/**
 * Class Caller
 * @package Ballybran\Core\Caller
 */
class Caller implements CallerInterface
{
    /**
     * @var
     */
    public $caller;
    /**
     * @var string
     */
    public $module;
    /**
     * @var string
     */
    protected $namespace = __NAMESPACE__;


    /**
     * @param $funcname
     * @param array $args
     * @return mixed
     */
    function __call($funcname, $args = array())
    {
        $this->setModuleInformation();

        if (!is_object($this->caller) && !function_exists('call_user_func_array')) {
            trigger_error("Call to Function with call_user_func_array failed", E_USER_ERROR);
            $this->unsetModuleInformation();
        }

        $return = call_user_func_array(array(&$this->caller, $funcname), $args);
        return $return;
    }

    /**
     * Caller constructor.
     * @param bool $callerClassName
     * @param string $callerModuleName
     */
    function __construct($callerClassName = false, $callerModuleName = 'Webboard')
    {
        if ($callerClassName == false) {
            trigger_error('No Classname', E_USER_ERROR);
        }

        $this->module = $callerModuleName;

        $pthOfObject = str_replace("\\", '/', $callerClassName) . '.php';

//        require_once  $pthOfObject;

        if (!class_exists($callerClassName)) {
            trigger_error('Class not exists: \'' . $callerClassName . '\'', E_USER_ERROR);

        }
        $this->caller = new $callerClassName();

        if (!is_object($this->caller) && !method_exists($this->caller, '__init')) {
            $this->unsetModuleInformation();
            trigger_error('Caller is no object!', E_USER_ERROR);
        }
        $this->setModuleInformation();
        $this->caller->__init();

    }

    /**
     *
     */
    function __destruct()
    {
        $this->setModuleInformation();
        if (! method_exists($this->caller, '__deinit')) {
            $this->unsetModuleInformation();
        }
        $this->caller->__deinit();

    }

    /**
     * @param $isset
     * @return bool
     */
    function __isset($isset)
    {
        $this->setModuleInformation();
        if (!is_object($this->caller)) {
            $this->unsetModuleInformation();
            trigger_error('Caller is no object!', E_USER_ERROR);
        }
        $return = isset($this->caller->{$isset});
        return $return;
    }

    /**
     * @param $unset
     */
    function __unset($unset)
    {
        $this->setModuleInformation();
        if (!is_object($this->caller) && !isset($this->caller->{$unset})) {
            trigger_error('Caller is no object!', E_USER_ERROR);
        }
        $this->unsetModuleInformation();
        unset($this->caller->{$unset});
    }


    /**
     * @param $set
     * @param $val
     */
    function __set($set, $val)
    {
        $this->setModuleInformation();
        if (!is_object($this->caller)) {
            trigger_error('Caller is no object!', E_USER_ERROR);
            $this->unsetModuleInformation();
        }
        $this->caller->{$set} = $val;
    }


    /**
     * @param $get
     * @return bool
     */
    function __get($get)
    {
        $this->setModuleInformation();
        if (!is_object($this->caller) && !isset($this->caller->{$get})) {

            trigger_error('Caller is no object!', E_USER_ERROR);
            $this->unsetModuleInformation();
        }
        $return = $this->caller->{$get};
        return $return;

    }

    function setModuleInformation()
    {
        $this->caller->module = $this->module;
    }

    function unsetModuleInformation()
    {
        $this->caller->module = NULL;
    }

}