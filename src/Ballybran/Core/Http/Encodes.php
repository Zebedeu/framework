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

namespace Ballybran\Core\Http;

class Encodes extends EncodeText
{


    public static function parse($arr)
    {
        $dom = new \DOMDocument(self::$version);
        self::recursiveParser($dom, $arr, $dom);
        return $dom->saveXML();
    }

    private static function recursiveParser(&$root, $arr, &$dom)
    {
        foreach ($arr as $key => $item) {
            if (is_array($item) && !is_numeric($key)) {
                $node = $dom->createElement($key);
                self::recursiveParser($node, $item, $dom);
                return $root->appendChild($node);
            } elseif (is_array($item) && is_numeric($key)) {
                return self::recursiveParser($root, $item, $dom);
            } else {
                $node = $dom->createElement($key, $item);
                return $root->appendChild($node);
            }
        }
    }

}