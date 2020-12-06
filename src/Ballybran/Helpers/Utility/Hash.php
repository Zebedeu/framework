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

namespace Ballybran\Helpers\Utility;

use Ballybran\Helpers\Log\Logger;
use const ALGO;
use Prophecy\Exception\InvalidArgumentException;
use function random_int;

class Hash implements HashInterface
{
    private $key;
    private static $RANDOM_LENGTH = 31;


    public function __construct()
    {
    }

    /**
     * @param $algo
     * @param $data
     * @param $salt
     * @return string
     */
    public static function Create(string $algo , string $data , string $salt): string
    {
        $context = hash_init( $algo , HASH_HMAC , $salt );
        hash_update( $context , $data );
        return hash_final( $context );
    }


    public static function simpleToken(int $length = 31 , $string = '')
    {
        $max = strlen( $string ) - 1;

        $token = '';

        for ($i = 0; $i < $length; $i++) {
            $token .= $string[random_int( 0 , $max )];
        }

        return $token;
    }

    /**
     * @param int $length lenght for tokon
     * @return string
     */
    public static function token(int $length = 1 , $constant = SECURE_AUTH_SALT): string
    {

        $string = $constant;

        $max = strlen( $string ) - 1;

        $token = '';

        if (!intVal( $length )) {
            throw new  InvalidArgumentException( 'tripleInteger function only accepts integers. Input was: ' . $length );

        }

        for ($i = 0; $i < $length; $i++) {
            $token .= self::Create( ALGO , uniqid( $string[random_int( 0 , $max )] ) , SECURE_AUTH_KEY );
        }

        return $token;
    }

    public static function hash_password($string , $const = PASSWORD_DEFAULT , $cust = null)
    {

        if (!is_null( $cust )) {

            return password_hash( $string , $const , ['cost' => $cust] );
        }
        return password_hash( $string , $const );


    }

    /**
     * @param string $string for password
     * @param string $hash password
     * @return bool
     */
    public static function verify_password(string $string , string $hash): bool
    {

        if (password_verify( $string , $hash )) {
            return true;

        } else {
            return false;
        }

    }

    static function gen_cert($userid)
    {
        $dn = array("countryName" => 'XX' , "stateOrProvinceName" => 'State' , "localityName" => 'SomewhereCity' , "organizationName" => 'MySelf' , "organizationalUnitName" => 'Whatever' , "commonName" => 'mySelf' , "emailAddress" => 'user@example.com');
        //Passphrase can be taken during registration
        //Here its initialized to 1234 for sample
        $privkeypass = 'root';
        $numberofdays = 365;
        //RSA encryption and 1024 bits length
        $privkey = openssl_pkey_new( array('private_key_bits' => 1024 , 'private_key_type' => OPENSSL_KEYTYPE_RSA) );
        $csr = openssl_csr_new( $dn , $privkey );
        $sscert = openssl_csr_sign( $csr , null , $privkey , $numberofdays );
        openssl_x509_export( $sscert , $publickey );
        openssl_pkey_export( $privkey , $privatekey , $privkeypass );
        openssl_csr_export( $csr , $csrStr );
        //Generated keys are stored into files
        file_put_contents('private_key.pem', "");
        file_put_contents('public_key.pem', "");
        file_put_contents('signature.dat', "");

        $fp = fopen( "private_key.pem" , "w" );
        fwrite( $fp , $privatekey );
        fclose( $fp );
        $fp = fopen( "signature.crt" , "w" );
        fwrite( $fp , $publickey );
        fclose( $fp );
    }

    //Encryption with public key
    static function encrypt($source)
    {
        $crt = '';
        //path holds the certificate path present in the system
        $path = "signature.crt";
        $fp = fopen( $path , "r" );
        $pub_key = fread( $fp , 8192 );
        fclose( $fp );
        openssl_get_publickey( $pub_key );
        //$source='';
        //$source="sumanth ahoiadodakjaksdsa;ldadkkllksdalkalsdl;asld;ls sumanthasddddddddddddddddddddddddddddddddfsdfsffdfsdfsumanth";
        $j = 0;
        $x = strlen( $source ) / 10;
        $y = floor( $x );
        for ($i = 0; $i < $y; $i++) {
            $crypttext = '';

            openssl_public_encrypt( substr( $source , $j , 10 ) , $crypttext , $pub_key );
            $j = $j + 10;
            $crt .= $crypttext;
            $crt .= ":::";
        }
        if ((strlen( $source ) % 10) > 0) {
            openssl_public_encrypt( substr( $source , $j ) , $crypttext , $pub_key );
            $crt .= $crypttext;
        }
        return (base64_encode($crt));

    }

    //Decryption with private key
    static function decrypt($crypttext)
    {
        $passphrase = "root";
        $str = '';
        $path = "private_key.pem";
        $fpp1 = fopen( $path , "r" );
        $priv_key = fread( $fpp1 , 8192 );
        fclose( $fpp1 );
        $res1 = openssl_get_privatekey( $priv_key , $passphrase );
        $tt = explode( ":::" , $crypttext );
        $cnt = count( $tt );
        $i = 0;
        while ($i < $cnt) {
            openssl_private_decrypt( $tt[$i] , $str1 , $res1 );
            $str .= $str1;
            $i++;
        }
        return $str;
    }

    static function sign($source)
    {
        $has = sha1( $source );
        $source .= "::";
        $source .= $has;
        $path = "signature.crt";
        $fp = fopen( $path , "r" );
        $pub_key = fread( $fp , 8192 );
        fclose( $fp );
        openssl_get_publickey( $pub_key );
        openssl_public_encrypt( $source , $mese , $pub_key );
        return $mese;

    }

    static function verify($crypttext , $userid)
    {
        $passphrase = "root";
        $path = "private_key.pem";
        $fpp1 = fopen( $path , "r" );
        $priv_key = fread( $fpp1 , 8192 );
        fclose( $fpp1 );
        $res1 = openssl_get_privatekey( $priv_key , $passphrase );
        openssl_private_decrypt( $crypttext , $has1 , $res1 );
        list( $c1 , $c2 ) = preg_split( "::" , $has1 );
        $has = sha1( $c1 );
        if ($has == $c2) {
            $message = $c1;
            return $message;
        }else{
            echo "noo";
        }
    }
}