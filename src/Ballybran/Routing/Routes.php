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

namespace Ballybran\Helpers\Routing;

use Ballybran\Exception\Exception;
use Ballybran\Exception\KException;
use Ballybran\Helpers\Language;

/**
 * Class Routes
 * @package Ballybran\Helpers\Routing
 */
class Routes
{
    private $path, $callable, $matches = [], $params = [];
    protected $_controllerPath = PV . APP . DS . "Controllers/";


    /**
     * Routes constructor.
     * @param string $path
     * @param $callable
     */
    public function __construct($path, $callable)
    {
        $this->path = trim($path, '/');
        $this->callable = $callable;

    }

    /**
     * @param string $params
     * @param string $regex
     * @return Routes
     * example with('id','[0-9]+')
     */
    public function with(string $params, string $regex): Routes
    {
        $this->params[$params] = str_replace('(', '(?:', $regex);
        return $this;
    }

    /**
     * @param string $url
     * @return bool
     */
    public function match($url) : bool
    {
        $url = trim($url, '/');
        $path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->path);

        $regex = "#^$path$#i";

        if (!preg_match($regex, $url, $matches)) {

            return false;
        }
        array_shift($matches);
        $this->matches = $matches;

        return true;
    }


    /**
     * @param array $match
     * @return string
     */
    private function paramMatch(array $match) : string
    {
        if (isset($this->params[$match[1]])) {
            return '(' . $this->params[$match[1]] . ')';
        }

        return '([^/]+)';
    }
	

        public function call()
    {
            
            if (is_string($this->callable)) {

                $params = explode('@', $this->callable);

                $file = $this->_controllerPath . $params[0] . '.php';

                $controller = $this->_controllerPath . $params[0] . '.php';
                $namespace = str_replace('/', '\\', $this->_controllerPath);
                $className = $namespace . $params[0];

                $controller = new $className;
                // $controller = new $controller();

                return call_user_func_array([$controller, $params[1]], $this->matches);

            } else {

                return call_user_func_array($this->callable, $this->matches);

            }

    }

    /**
     * @param $params
     * @return string
     */
    public function getUrl($params) : string
    {
        $path = $this->path;

        foreach ($params as $key => $value) {
            $path = str_replace(":$key", $value, $path);

        }
        return $path;
    }

    /*
	*@deprecated
	*/
    public static function route()
    {

        if (phpversion() > 7.0) {
            $bootstrap = new Bootstrap();
            $bootstrap->init();
        } else {
            $lang = new Language();
            $lang->Load('welcome');
            KException::error("<p class='btn btn-warning'>" . $lang->get("version") . "</p>");
        }

    }
}
