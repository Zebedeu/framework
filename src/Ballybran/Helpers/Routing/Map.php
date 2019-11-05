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

use Ballybran\Core\Http\RestUtilities;
use Ballybran\Exception\KException;
use Ballybran\Helpers\vardump\Vardump;

/**
 * Class Map
 * @package Ballybran\Helpers\Routing
 */
class Map extends Bootstrap
{
    private  $url;
    private  $callable;
    private  $routes =[];
    private  $nameRoute;


    public function __construct()
    {

        $url = $_GET['url'] ?? "/";
        $this->url = $url;
    }

    /**
     * @param $path
     * @param $callable
     * @param null $name
     * @return Route
     * example $router->add( '/user/:id', function($id) {}, 'name')->with('id','[0-9]+');
     */
    public function get($path, $callable, $name = null) : Routes
    {

        /** @var TYPE_NAME $callable */
        return self::add($path, $callable, $name, 'GET');

    }

    /**
     * @param $path
     * @param $callable
     * @param null $name
     * @return Routes
     * example $router->post( '/user/:id', function() {}, 'name')
     */
    public  function post($path, $callable, $name = null) : Routes
    {

        return self::add($path, $callable, $name, 'POST');


    }

    /**
     * @param $path
     * @param $callable
     * @param $name
     * @param $method
     * @return Routes
  	* example $router->add( '/user/:id', function($id) {}, 'name')->with('id','[0-9]+');
     */
    public  function add($path, $callable, $name, $method) : Routes
    {
        $route = new Routes($path, $callable);
        $this->routes[$method][] = $route;

        if (is_string($callable) && $name === null) {

            $name = $callable;

        }
        if ($name) {
            $this->nameRoute[$name] = $route;
        }
        return $route;

    }

    public  function run()
    {
        if (!isset($this->routes[$_SERVER['REQUEST_METHOD']])) {
            throw new \Exception(' REQUEST_METHOD does not exists', 1);

        }

        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {

            if ($route->match($this->url)) {

                return $route->call();
            }
        }

            RestUtilities::sendResponse(200);
            KException::notFound();

    }
    /*
     * @param $name
     * @param $params array optional 
	 * $router->url('name', ['id'=> 1] )
	* example $router->get( '/user/:id', function($id) { return $router->url('name', ['id'=> 1] ) }, 'name')->with('id','[0-9]+');
	*/

    public function url($name, $params = [])
    {
        if (!isset($this->nameRoute[$name])) {

            throw new \Exception("No route match this name", 1);

        }

        return $this->nameRoute[$name]->getUrl($params);
    }


}