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

use Ballybran\Helpers\{
    Http\Http
};


/**
 * Class System
 * @package Ballybran\Helpers
 */
class System extends Http
{

    /**
     * @return float
     */
    private static function microtime_float()
    {
        $time = explode(" ", microtime());
        foreach ($time as $item => $value) {
            return ((float)$item + (float)$value);
        }
        return false;
//
    }

    /**
     * @return string
     */
    public static function time_start(): string
    {

        $time_start = self::microtime_float();

        // Sleep for a while
        usleep(100);

        $time_end = self::microtime_float();
        $time = $time_end - $time_start;

        return "Loaded in $time seconds\n";

    }

}