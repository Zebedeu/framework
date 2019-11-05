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

namespace Ballybran\Helpers\Copyright;

use Ballybran\Helpers\Security\ValidateTypes;

class Copyright extends ValidateTypes implements CopyrightInterface
{

    private static $date;
    private static $data_last = 2015;

    public static function copyright(int $data_last = NULL, string $name = "knut7 FRAMWORK")
    {

        self::$date = date('y');
        if (self::getSQLValueString($data_last, 'int')) {
            return "Copyright (c)\n" . $data_last . "\n-" . self::$date . "\n" . $name . "\n" . "All Rights Reserved";
        }
        return "Copyright (c)\n" . self::$data_last . "\n-" . self::$date . "\n" . $name . "\n" . "All Rights Reserved";

    }

}
