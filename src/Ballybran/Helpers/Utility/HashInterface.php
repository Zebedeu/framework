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

namespace Ballybran\Helpers\Utility;


interface HashInterface
{

    public function __construct();
    public static function Create(String $algo, String $data, String $salt) : String;

    /**
     * @param int $length lenght for tokon
     * @return string
     */
    public static function token(int $length = 1, $constant = SECURE_AUTH_SALT) : String;

    public static function hash_password($string, $const = PASSWORD_DEFAULT, $cust = null);
    
    /**
    * @param string $string  for password
    * @param string $hash password
    * @return bool
    */
    public static  function verify_password( string $string, string $hash) : bool;

}