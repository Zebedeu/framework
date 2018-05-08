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

use Ballybran\Exception\Exception;
use Ballybran\Exception\KException;
use Ballybran\Helpers\Language;

/**
 * Class Routes
 * @package Ballybran\Helpers\Routing
 */
class Routes
{
    private static $routes;
     static $type;

    public function __construct()
    {
        /** @var  $routerPath */

        $routerPath =  'Config/route.php';

        self::$routes = include($routerPath);

//
//        $module = func_get_args();
//
//        foreach ($module as $key => $value ) {
//        }



        $uri = self::getURI();

        foreach (self::$routes as $uripattern => $path) {

            if (preg_match("~$uripattern~", $uri)) {
//
                $internaroute = preg_replace("~$uripattern~",  $path, $uri);


                $segmento = explode('/', $internaroute);

                $controllerName = array_shift($segmento) . 'Controller';


                $controllerName = ucfirst($controllerName);

                $actionName = 'action' . ucfirst(array_shift($segmento));

                $parameters = $segmento;
                $controllerPath = DIR_FILE . '/controllers/' .$controllerName . '.php';

                if(file_exists($controllerPath)) {
                    include_once ($controllerPath);

                    $objec = new $controllerName;

                    $result = call_user_func_array(array ($objec, $actionName), $parameters);
                    if ($result != null) {
                        break;
                    }
                }
                }
            }
    }

    /**
     * @return string
     */
    public static function getURI()
    {

        $url = $_GET['url'] ?? null;
        $url = rtrim($url, '/');
        return $url = filter_var($url, FILTER_SANITIZE_URL);
    }

    public static function route() {
        if( phpversion() > 7.0  ) {
            $bootstrap = new Bootstrap();
            $bootstrap->init();
        }else {
            $lang = new Language();
            $lang->Load('welcome');
             KException::error("<p class='btn btn-warning'>".$lang->get("version")."</p>");
        }
    }
}
