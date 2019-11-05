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

/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 22/11/17
 * Time: 02:23
 */

namespace Ballybran\Helpers\Event;


class FlashMessage
{

    private $flash;

    public function __construct()
    {
    }

    public static function sucess($suucsss)
    {

        return $suucsss;
    }

    public static function Warning($suucsss)
    {

        return $suucsss;
    }

    public static function display($closure, $message)
    {
        return call_user_func(array(self::class, $closure), $message);
    }

    public function sendMessage()
    {

//        return  $this->display($this->sucess(), "Please!! data invaid");
    }
}