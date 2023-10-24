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

namespace Ballybran\Helpers\Security;

use Symfony\Component\HttpFoundation\Session\Session as SessionHttp;

/**
 * Class Session
 * @package Ballybran\Helpers\Security
 */
class Session
{

    private static $session;

    public static function init()
    {
        self::$session = new SessionHttp();
        self::$session->start();
    }

    public static function set($key, $value)
    {
        self::$session->set($key, $value);
    }

    public static function get($key, $default = null) 
    {
        return self::$session->get($key, $default);
    }

    public static function remove($key)
    {
        self::$session->remove($key);
    }

    public static function destroy()
    {
        self::$session->clear();
    }

    public static function exist($key)
    {
        return self::$session->has($key);
    }

    public static function flash($key, $message)
    {
        self::$session->getFlashBag()->add($key, $message);
    }

    public static function errors()
    {
        $errors = self::$session->getFlashBag()->get('errors', []);
        self::$session->getFlashBag()->clear();
        return $errors;
    }

    public static function regenerateId()
    {
        self::$session->migrate();
    }

    public static function invalidate()
    {
        self::$session->invalidate();
    }

}