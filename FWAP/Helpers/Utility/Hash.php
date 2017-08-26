<?php

/**
 * knut7 Framework (http://framework.artphoweb.com/)
 * knut7 FW(tm) : Rapid Development Framework (http://framework.artphoweb.com/)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @link      http://github.com/zebedeu/artphoweb for the canonical source repository
 * Copyright (c) 2017.  knut7  Software Technologies AO Inc. (http://www.artphoweb.com)
 * @license   http://framework.artphoweb.com/license/new-bsd New BSD License
 * @author    Marcio Zebedeu - artphoweb@artphoweb.com
 * @version   1.0.0
 */

namespace FWAP\Helpers\Utility;

class Hash {
    private $key;



    /**
     * @param $algo
     * @param $data
     * @param $salt
     * @return string
     */
    public static function Create($algo, $data, $salt) {
        $context = hash_init($algo, HASH_HMAC, $salt);
        hash_update($context, $data);

        return hash_final($context);
    }

    public function encrypt($msg, $k, $base64 = false) {
        $td = mcrypt_module_open('rijndael-256', '', 'ctr', '');

        if (!$td) {
            return false;
        }

        $iv = mcrypt_create_iv(32, MCRYPT_RAND);

        if (mcrypt_generic_init($td, $k, $iv) !== 0) {
            return false;
        }

        $msg = mcrypt_generic($td, $msg);
        $msg = $iv . $msg;
        $mac = $this->pbkdf2($msg, $k, 1000, 32);
        $msg .= $mac;

        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);

        if ($base64) {
            $msg = base64_encode($msg);
        }

        return $msg;
    }

    public function decrypt($msg, $k, $base64 = false) {
        if ($base64) {
            $msg = base64_decode($msg);
        }

        if (!$td = mcrypt_module_open('rijndael-256', '', 'ctr', '')) {
            return false;
        }

        $iv = substr($msg, 0, 32);
        $mo = strlen($msg) - 32;
        $em = substr($msg, $mo);
        $msg = substr($msg, 32, strlen($msg) - 64);
        $mac = $this->pbkdf2($iv . $msg, $k, 1000, 32);

        if ($em !== $mac) {
            return false;
        }

        if (mcrypt_generic_init($td, $k, $iv) !== 0) {
            return false;
        }

        $msg = mdecrypt_generic($td, $msg);
        $msg = unserialize($msg);

        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);

        return $msg;
    }

    public function pbkdf2($p, $s, $c, $kl, $a = 'sha256') {
        $hl = strlen(hash($a, null, true));
        $kb = ceil($kl / $hl);
        $dk = '';

        for ($block = 1; $block <= $kb; $block++) {

            $ib = $b = hash_hmac($a, $s . pack('N', $block), $p, true);

            for ($i = 1; $i < $c; $i++)
                $ib ^= ($b = hash_hmac($a, $b, $p, true));

            $dk .= $ib;
        }

        return substr($dk, 0, $kl);
    }

    public static function token($length = 32) {
        // Create random token
        $string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

        $max = strlen($string) - 1;

        $token = '';

        for ($i = 0; $i < $length; $i++) {
            $token .= $string[mt_rand(0, $max)];
        }

        return $token;
    }

}
