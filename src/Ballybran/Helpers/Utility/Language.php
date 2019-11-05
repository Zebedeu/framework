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

use Ballybran\Exception\Exception;
use Ballybran\Helpers\vardump\Vardump;

/**
 * Class Language
 * @package Ballybran\Helpers
 */
class Language
{

    /**
     * Variable holds array with language.
     *
     * @var array
     */
    private $array;

    /**
     * Load language function.
     *
     * @param string $name
     * @param string $code
     */
    public function Load($name, $value = null)
    {
        /** lang file */
        $file = __DIR__ . '/../../' . DIR_LANGUAGE . LANGUAGE_CODE . DS . "$name.php";

        /** check if is readable */
        if (is_readable($file)) {
            /** require file */
            $array = include($file);
        } else {
            /** display error */
            echo Exception::langNotLoad();
        }

        if (!empty($array[$value])) {
            return $array[$value];
        } else {
            return $value;
        }
    }


    /**
     * Get element from language array by key.
     *
     * @param  string $value
     *
     * @return string
     */
    public function get($value)
    {
        if (!empty($this->array[$value])) {
            return $this->array[$value];
        } else {
            return $value;
        }
    }

    /**
     * Get lang for views.
     *
     * @param  string $value this is "word" value from language file
     * @param  string $name name of file with language
     * @param  string $code optional, language code
     *
     * @return string
     */
    public static function show($value, $name = null)
    {
        /** lang file */
        $file = __DIR__ . '/../../' . DIR_LANGUAGE . LANGUAGE_CODE . DS . "$name.php";

        /** check if is readable */
        if (is_readable($file)) {
            /** require file */
//            $array = include($file);
        } else {
            /** display error */
            echo Exception::langNotLoad();
        }

        if (!empty($array[$value])) {
            return $array[$value];
        } else {
            return $value;
        }
    }
}
