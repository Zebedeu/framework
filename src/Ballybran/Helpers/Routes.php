<?php
/**
 *
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
 * @version   1.0.7
 *
 *
 */

namespace Ballybran\Helpers;

use Ballybran\Exception\Exception;
use Ballybran\Exception\KException;
use Ballybran\Helpers\Language;

/**
 * Class Routes
 * @package Ballybran\Helpers\Routing
 */
class Routes
{
    public static $validRoutes = array();

    public static function set($route, \Closure $closure)
    {

        self::$validRoutes[] = $route;

        if ($_GET['url'] == $route) {
            $closure->__invoke();
        }
    }
}
