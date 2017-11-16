<?php
/**
 * APWEB Framework (http://framework.artphoweb.com/)
 * APWEB FW(tm) : Rapid Development Framework (http://framework.artphoweb.com/)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @link      http://github.com/zebedeu/artphoweb for the canonical source repository
 * @copyright (c) 2015.  APWEB  Software Technologies AO Inc. (http://www.artphoweb.com)
 * @license   http://framework.artphoweb.com/license/new-bsd New BSD License
 * @author    Marcio Zebedeu - artphoweb@artphoweb.com
 * @version   1.0.0
 */

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ballybran\Helpers\Http;

/**
 * Description of Coockie
 *
 * @author artphotografie
 */
class Cookie
{

    private $name = [];

    /**
     * @param $name
     * @param int $maxage time in second, for example : 60 = 1min
     * @param string $path
     * @param string $domain
     * @param bool $secure
     * @param bool $HTTPOnly
     * @return bool
     */
    function createCookie($name, $maxage = 0, $path = '', $domain = '', $secure = false, $HTTPOnly = false)
    {
//if(is_array($name))
//{
//list($k,$v)    =    each($name);
//
//$name    =    $k.'['.$v.']';
//
//}
        $ob = ini_get('output_buffering');


// Abort the method if headers have already been sent, except when output buffering has been enabled
        if (headers_sent() && (bool)$ob === false || strtolower($ob) == 'off')
            return false;
        if (!empty($domain)) {
            // Fix the domain to accept domains with and without 'www.'.
            if (strtolower(substr($domain, 0, 4)) == 'www.') $domain = substr($domain, 4);
            // Add the dot prefix to ensure compatibility with subdomains
            if (substr($domain, 0, 1) != '.') $domain = '.' . $domain;
            // Remove port information.
            $port = strpos($domain, ':');
            if ($port !== false) $domain = substr($domain, 0, $port);
        }
// Prevent "headers already sent" error with utf8 support (BOM)
//if ( utf8_support ) header('Content-Type: text/html; charset=utf-8');
        if (is_array($name)) {
            foreach ($name as $k => $v) {


                header('Set-Cookie: ' . $k . '=' . rawurlencode($v)
                    . (empty($domain) ? '' : '; Domain=' . $domain)
                    . (empty($maxage) ? '' : '; Max-Age=' . $maxage)
                    . (empty($path) ? '' : '; Path=' . $path)
                    . (!$secure ? '' : '; Secure')
                    . (!$HTTPOnly ? '' : '; HttpOnly'), false);
            }
        } else {
            $value = "";
            header('Set-Cookie: ' . rawurlencode($name) . '=' . rawurlencode($value)
                . (empty($domain) ? '' : '; Domain=' . $domain)
                . (empty($maxage) ? '' : '; Max-Age=' . $maxage)
                . (empty($path) ? '' : '; Path=' . $path)
                . (!$secure ? '' : '; Secure')
                . (!$HTTPOnly ? '' : '; HttpOnly'), false);
        }
        return true;
    }
}
