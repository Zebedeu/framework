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

namespace Ballybran\Helpers\Security;

use Ballybran\Helpers\Hook;
use Module\Service\AbstractModel;

/**
 * Class Session
 * @package Ballybran\Helpers\Security
 */
class Session {


    /**
     * @var string
     */
    private static  $expire;

    /**
     * Session constructor.
     * @param AbstractModel $model
     */
    function __construct()
    {
//        register_shutdown_function('session_write_close');
//        self::$expire = ini_get('session.gc_maxlifetime');
    }

    /**
     *  init Sessin our Session Start
     * É usado para ativar o incio de sassão do usuário.
     */
    public static function init($name = 'knut7_session') {

//        @session_start();
       static $create_sessions= array();
       @session_start();
//       if(session_id() != '') {
//           session_write_close();
//       }
//       session_name($name);
//       if(isset($_COOKIE[$name])) {
//           $create_sessions[$name] =$_COOKIE[$name];
//       }
//       if(isset($create_sessions[$name])) {
//           session_id($create_sessions[$name]);
//           @session_start(
//               [
//                   'cookie_lifetime' => 86400,
////                   'cache_limiter' => 'private',
//                   'read_and_close'  => false,
//               ]
//           );
//       } else {
//           session_start(
//               [
//                   'cookie_lifetime' => 86400,
////                   'cache_limiter' => 'private',
//                   'read_and_close'  => false,
//               ]
//           );
//           $_SESSION = array();
//           session_regenerate_id(empty($create_sessions));
//           $create_sessions[$name] = session_id();
//       }
    }

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public static function set($key, $value) {
        return $_SESSION[$key] = $value;
    }

    /**
     * @param $key
     * @return mixed
     */
    public static function get($key) {

        return $_SESSION[$key];
    }

    /**
     * funtion usado para destruir a sessao
     *  exxemplo de uso:: public function DestruirSessao(){ Session::Destroy() }
     */
    public static function Destroy() {
            session_destroy();

    }

    /**
     * @param $key
     */
    public static function unsetValue($key) {
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
    public static function exist() {
        if (sizeof($_SESSION) > 0) {
            ini_set('session.use_only_cookies', 'Off');
            ini_set('session.use_cookies', 'On');
            ini_set('session.cookie_httponly', 'On');


            if (isset($_COOKIE[session_name()]) && !preg_match('/^[a-zA-Z0-9,\-]{22,52}$/', $_COOKIE[session_name()])) {
                exit('Error: Invalid session ID!');
            }

            session_set_cookie_params(0, '/');
            return true;
        } else {
            return false;
        }
    }

//    public static function handleLogin() {
//        @session_start();
//        Session::init();
//        $logged = Session::get('U_NAME');
//        $role = Session::get('role');
//        if ($logged == false || $role != 'owner') {
//            session_destroy();
//            \Ballybran\Helpers\Http\Hook::Header('login');
//            exit;
//        }
//    }


}
