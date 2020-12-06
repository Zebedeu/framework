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

use Ballybran\Helpers\Hook;
use http\Url;

/**
 * Class Session
 * @package Ballybran\Helpers\Security
 */
class Session
{


    /**
     * @var string
     */


    /**
     *  init Sessin our Session Start
     * É usado para ativar o incio de sassão do usuário.
     */
    public static function init()
    {
        if (headers_sent()) {
            return;
        }

        $id = session_id();
        if (empty( $id )) {
            @session_start(
                [
                    'cookie_lifetime' => 86400 ,
//            'read_and_close'  => true,
                ]
            );
        }
    }

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public static function set($key, $value)
    {
        return $_SESSION[$key] = $value;
    }

    /**
     * @param $key
     * @return mixed
     */
    public static function get($key)
    {
        if(isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
    }

    /**
     * funtion usado para destruir a sessao
     *  exxemplo de uso:: public function DestruirSessao(){ Session::Destroy() }
     */
    public static function Destroy()
    {
        @session_destroy();

    }

    /**
     * @param $key
     */
    public static function unsetValue($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    /**
     *  Usa-se como condicao. Se o usuario existe ou se for maior que zero ( > 0 )
     * entao, isso significa que o usuario existe
     * mais se for menor q zero ( < 0 ) sigifica que o usuario nao existe.
     * exemplo de uso: Session::exist(){
     *  .. .. .. .. your code .. .. .. .
     * }
     * @return bool
     */
    public static function exist()
    {
        if (sizeof($_SESSION) > 0) {
            session_regenerate_id();
            return true;
        } else {
            return false;
        }
    }


}
