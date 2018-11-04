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

namespace Ballybran\Helpers\Routing;

use \Ballybran\Exception\KException;

/**
 * Class Bootstrap
 * @package Ballybran\Helpers\Routing
 */
final class Bootstrap
{

    private $_url = null;
    private $_controller = "";
    private $_controllerPath = PV . APP . DS . "Controllers/";
    private $_modelPath = 'Models';
    private $_errorFile = 'Error.php';
    private $_defaultFile = 'Index.php';

    /**
     * Starts the Bootstrap
     *
     * @return boolean
     */

    public function init() : bool
    {
        // Sets the protected $_url
        $this->_getUrl();

        // Load the default Controller if no URL is set
        // eg: Visit http://localhost it loads Default Controller
        if (empty($this->_url[0])) {
            $this->_loadDefaultController();
            return false;
        }

        $this->_loadExistingController();
        $this->_callControllerMethod();
        return true;
    }

    /**
     * (Optional) Set a custom path to Controllers
     * @param string $path
     */
    public function setControllerPath( $path )
    {
        $this->_controllerPath = trim($path, '/') . '/';
    }

    /**
     * (Optional) Set a custom path to models
     * @param string $path
     */
    public function setModelPath( $path )
    {
        $this->_modelPath = trim($path, '/') . '/';
    }

    /**
     * (Optional) Set a custom path to the error file
     * @param string $path Use the file name of your Controller, eg: error.php
     */
    public function setErrorFile( $path )
    {
        $this->_errorFile = trim($path, '/');
    }

    /**
     * (Optional) Set a custom path to the error file
     * @param string $path Use the file name of your Controller, eg: Index.php
     */
    public function setDefaultFile( $path )
    {
        $this->_defaultFile = trim($path, '/');
    }


    /**
     * Fetches the $_GET from 'url'
     */
    private function _getUrl()
    {
        $url = $_GET['url'] ?? "index";
        $url = rtrim($url, '/');
//        $url = filter_var($url, FILTER_SANITIZE_URL);
        $this->_url = explode('/', $url);

    }

    /**
     * This loads if there is no GET parameter passed
     */
    private function _loadDefaultController()
    {
        require_once ($this->_controllerPath . $this->_defaultFile);
        return $this->_controller->index();
    }

    /**
     * Load an existing Controller if there IS a GET parameter passed
     *
     * @return boolean|string
     */
    private function _loadExistingController()
    {

        $file = $this->_controllerPath . ucfirst($this->_url[0]) . '.php';

        if (!file_exists($file)) {
            $this->_error();
            return false;
        }
        require($file);

        $namespace = str_replace('/', '\\', APP. '/Controllers/');
        $className = $namespace . $this->_url[0];

        $this->_controller = new $className;
        return true;

    }

    /**
     * If a method is passed in the GET url paremter
     *
     *  http://localhost/Controller/method/(param)/(param)/(param)
     *  url[0] = Controller
     *  url[1] = Method
     *  url[2] = Param
     *  url[3] = Param
     *  url[4] = Param
     */
    private function _callControllerMethod()
    {
        $length = count($this->_url);

        // Make sure the method we are calling exists
        if ($length > 1) {
            if (!method_exists($this->_controller, $this->_url[1])) {
                $this->_error();
            }
        }

        // Determine what to load
        switch ($length) {
            case 5:
                //controller->Method(Param1, Param2, Param3)
                $this->_controller->{strtolower($this->_url[1])}(strtolower($this->_url[2], $this->_url[3], $this->_url[4]));
                break;

            case 4:
                //controller->Method(Param1, Param2)
                $this->_controller->{strtolower($this->_url[1])}(strtolower($this->_url[2], $this->_url[3]));
                break;

            case 3:
                //Controller->Method(Param1, Param2)
                $this->_controller->{strtolower($this->_url[1])}(strtolower($this->_url[2]));
                break;

            case 2:
                //controller->Method(Param1, Param2)

                $this->_controller->{strtolower($this->_url[1])}();
                break;

            default:
//                var_dump($this->_controller->index()); die;
                $this->_controller->index();

                break;
        }
    }

    /**
     * Display an error page if nothing exists
     *
     * @return boolean
     */
    private function _error()
    {
        KException::notFound();

        exit;
    }
}