<?php
/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 11/04/18
 * Time: 07:45
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

    public static  function verify_password($string, $hash);

}