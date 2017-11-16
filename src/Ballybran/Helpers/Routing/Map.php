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

namespace Ballybran\Helpers\Routing;
use Ballybran\Helpers\Routing\Routes;
use Ballybran\Helpers\vardump\Vardump;

/**
 * Created by PhpStorm.
 * User: artphotografie
 * Date: 17/10/17
 * Time: 23:28
 */
class Map
{
    private static $url, $var, $callback;

    public static function add($url, $var, $callback)
    {
        self::$url[] = $url;
        self::$var[] = $var;
        self::$callback[] = $callback;

        return new Map();

    }

    public static function exe()
    {
        $url = explode('/', Routes::getURI() );

//
        foreach (self::$url as $key => $value) {


            $value = explode('/', $value);


            foreach ($value as $k => $v)
                $map[] = $v == '*' ? isset($url[$k]) ? $url[$k] : null : $v;

//
            $map = implode('/', $map);
            Vardump::dump($map);

//
            if ($map == Routes::getURI() || $map == Routes::$type . '/' || $map == Routes::$type . '')
                return call_user_func(self::$callback[$key], self::$var[$key]);
            unset($map);
        }
//        Router::__404();
    }

}