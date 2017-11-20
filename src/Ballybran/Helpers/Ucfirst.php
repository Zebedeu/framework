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

namespace Ballybran\Helpers;

class Ucfirst {


    /**
     * @param $post
     * @param array $a_char
     * @return string
     */
    public static function _ucfirst($post, $a_char = array("'", "-", " ")) {

        $string = strtolower($post);
        foreach ($a_char as $temp) {
            $pos = strpos($string, $temp);

            if ($pos) {

                $mend = '';
                $a_split = explode($temp, $string);
                foreach ($a_split as $temp2) {
                    $mend .= ucfirst($temp2) . $temp;
                }
                $string = substr($mend, 0, -1);
            }
        }
        return ucfirst($string);
    }

}
