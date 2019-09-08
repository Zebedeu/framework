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

namespace Ballybran\Core\REST;

class EncodeText
{

    protected static $version = '1.0';
    private static $encode = 'UTF-8';


    public static function encodeHtml($responseData): string
    {

        $htmlResponse = "<table border='1'>";
        foreach ($responseData as $key => $value) {
            $htmlResponse .= "<tr><td>" . $key . "</td><td>" . $value . "</td></tr>";
        }
        $htmlResponse .= "</table>";
        return $htmlResponse;
    }

    public static function encodeJson($responseData): string
    {
        $jsonResponse = json_encode($responseData);
        return $jsonResponse;
    }

    public static function encodeXml($responseData): string
    {
        // creating object of SimpleXMLElement
        $version = self::$version;
        $encoding = self::$encode;
        $xml = new \SimpleXMLElement("<?xml version='$version' encoding='$encoding' ?>\n<mobile></mobile>");

        foreach ($responseData as $key => $variable) {

            foreach ($variable as $k => $v) {
                $xml->addChild($k , $v);
            }

        }
        return $xml->asXML();
    }
}