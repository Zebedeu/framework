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

use Ballybran\Helpers\Routing\Routes;
use Ballybran\Helpers\vardump\Vardump;

/**
 * Class Map
 * @package Ballybran\Helpers\Routing
 */
class Map
{
    private $url , $callable , $routes = [] , $nameRoute;


    public function __construct()
    {

        $url = $_GET['url'] ?? "index";
        $this->url = $url;
    }

    public function get($path , $callable , $name = null)
    {

        return $this->add($path , $callable , $name , 'GET');

    }

    public function post($path , $callable , $name = null)
    {

        return $this->add($path , $callable , $name , 'POST');


    }

    public function add($path , $callable , $name , $method)
    {

        $route = new Routes($path , $callable);
        $this->routes[$method][] = $route;

        if (is_string($callable) && $name = null) {

            $name = $callable;
        }
        if ($name) {
            $this->nameRoute[$name] = $route;
        }
        return $route;

    }

    public function run()
    {
        if (!isset($this->routes[$_SERVER['REQUEST_METHOD']])) {
            throw new \Exception(' REQUEST_METHOD does not exists' , 1);

        }

        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {

            if ($route->match($this->url)) {

                return $route->call();
            }
        }

        throw new \Exception("No  matching routes" , 1);

    }

    public function url($name , $params = [])
    {
        if (!isset($this->nameRoute[$name])) {

            throw new \Exception("No route match this name" , 1);

        }

        return $this->nameRoute[$name]->getUrl($params);
    }


}