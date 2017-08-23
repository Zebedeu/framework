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
 * @copyright (c) 2016.  APWEB  Software Technologies AO Inc. (http://www.artphoweb.com)
 * @license   http://framework.artphoweb.com/license/new-bsd New BSD License
 * @author    Marcio Zebedeu - artphoweb@artphoweb.com
 * @version   1.0.0
 */

namespace FWAP\Helpers\Routing;

use FWAP\Exception\FWAPException;
use FWAP\Helpers\Language;

class Routes
{
    private $routes;

    public function __construct()
    {
        /** @var  $routerPath */

        $routerPath = 'Config/routes.php';

        $this->routes = include($routerPath);
    }

    /**
     * @return string
     */
    private function getURI()
    {

        /** @var TYPE_NAME $_SERVER */
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    /**
     *
     */
    public function run()
    {
        $uri = $this->getURI();
        foreach ($this->routes as $uripattern => $path) {
//
//            echo $uripattern . '<br/>';
//            echo $path. '<br/>';
//            echo $uri;
//
            if (preg_match("~$uripattern~", $uri)) {
//
//                $internaroute = preg_replace(" ~$uripattern~ ", $path,  $uri);

//
                $segmento = explode('/', $path);
//
                $controllerName = array_shift($segmento) . 'Controller';

//                echo $controllerName;
                $controllerName = ucfirst($controllerName);

                $actionName = 'action' . ucfirst(array_shift($segmento));

                $parameters = $segmento;


                $controllerPath = DIR_FILE . '/Controllers/' . $controllerName . '.php';

                if(file_exists($controllerPath))
                {
                    include_once $controllerPath;

                }

                $objec = new $controllerName;


                $result = call_user_func_array(array($objec, $actionName), $parameters);

                if($result != null){
                    break;
                }
            }
        }
    }

    public static function route() {
        if( 7.1 >= phpversion()  ) {
            $bootstrap = new \FWAP\Helpers\Routing\Bootstrap();
            $bootstrap->init();
        }else {
            $lang = new Language();
            $lang->Load('welcome');
            FWAPException::error("<p class='btn btn-warning'>".$lang->get("version")."</p>");
        }
    }
}
