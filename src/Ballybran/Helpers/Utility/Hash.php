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

use const ALGO;
use Prophecy\Exception\InvalidArgumentException;
use function random_int;

class Hash {
    private $key;

    /**
     * @param $algo
     * @param $data
     * @param $salt
     * @return string
     */
    public static function Create(String $algo, String $data, String $salt) : String {
        $context = hash_init($algo, HASH_HMAC, $salt);
        hash_update($context, $data);

        return hash_final($context);
    }


    public static function simpleToken(int $length = 31, $string= '' ){
         $max = strlen($string) - 1;

         $token = '';

         for ($i = 0; $i < $length; $i++) {
            $token .= $string[random_int(0, $max)];
        }

        return $token;
    }

    /**
     * @param int $length lenght for tokon
     * @return string
     */
    public static function token(int $length = 1, $constant = SECURE_AUTH_SALT) : String {

        $string = $constant;

        $max = strlen($string) - 1;

        $token = '';

        if(! intVal($length)) {
            throw new  InvalidArgumentException('tripleInteger function only accepts integers. Input was: '.$length);

        }

        for ($i = 0; $i < $length; $i++) {
            $token .= self::Create(ALGO,  uniqid($string[random_int(0, $max)]), SECURE_AUTH_KEY);
        }

        return $token;
    }

    public static function hash_password($string, $const = PASSWORD_DEFAULT, $cust = null) {

        if(! is_null($cust) ) {

            return password_hash($string, $const,  ['cost' => $cust]);
        }
            return password_hash($string, $const);


    }

    public static  function verify_password($string, $hash)
    {

        if ( password_verify($string, $hash)) {
            return true;

        } else {
            return false;
        }

    }
}
