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

namespace Ballybran\Helpers\Stdlib;

class HydratorConverter
{

    /**
     * Convert an array to object
     * @param  array $array
     * @return object
     */


    public static function toObject(array $array, $object): object
    {
        $class = get_class($object);

        $methods = get_class_methods($class);

        foreach ($methods as $method) {

            preg_match(' /^(set)(.*?)$/i', $method, $results);

            $pre = $results[1] ?? '';

            $k = $results[2] ?? '';

            $k = strtolower(substr($k, 0, 1)) . substr($k, 1);

            if ($pre == 'set' && !empty($array[$k])) {

                $object->$method($array[$k]);
            }
        }
        return $object;
    }

    /**
     * Extract values from an object
     * converting the object to an associative array
     * @param  object $object
     * @return array
     */
    public static function toArray($object): array
    {
        $array = array();

        $class = get_class($object);

        $methods = get_class_methods($class);

        foreach ($methods as $method) {

            preg_match(' /^(get)(.*?)$/i', $method, $results);

            $pre = $results[1] ?? '';

            $k = $results[2] ?? '';

            $k = strtolower(substr($k, 0, 1)) . substr($k, 1);

            if ($pre == 'get') {

                $array[$k] = $object->$method();
            }
        }
        return array_filter($array);
    }
}