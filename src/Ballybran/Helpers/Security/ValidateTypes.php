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


/**
 * Class ValidateTypes
 * @package Ballybran\Helpers\Security
 */
class ValidateTypes
{

    public static function getSQLValueString($theValue , $theType , $theDefinedValue = "" , $theNotDefinedValue = "")
    {

        $theValue = function_exists("htmlspecialchars") ? htmlspecialchars($theValue) : htmlspecialchars($theValue);

        switch ($theType) {
            case "string":
                if (!is_string($theValue)) {
                    return null;
                }
                return strip_tags("$theValue");
                break;
            case "email":
                if (!is_string($theValue)) {
                    return null;
                }
                return filter_var($theValue , FILTER_VALIDATE_EMAIL);
                break;
            case "long":
            case "int":
                if (!is_numeric($theValue)) {
                    return null;
                }
                return intval($theValue);
                break;
            case "double":
                if (!is_double($theValue)) {
                    return null;
                }
                return floatval($theValue);
                break;
            case "date":

                $theValue = ($theValue != "") ? "" . $theValue . "" : null;
                break;
            case "url":
                if (!is_string($theValue)) {
                    return null;
                }
                return filter_var($theValue , FILTER_VALIDATE_URL);
                break;
            case "domain":
                if (!is_string($theValue)) {
                    return null;
                }
                return filter_var($theValue , FILTER_VALIDATE_DOMAIN);
                break;
            case "ip":
                if (!is_double($theValue)) {
                    return null;
                }
                return filter_var($theValue , FILTER_VALIDATE_IP);
                break;
            case "defined":
                $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
                break;
        }
        return $theValue;
    }


}