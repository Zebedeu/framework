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

namespace Ballybran\Helpers\Security;


/**
 * Class Val
 * @package Ballybran\Helpers\Security
 */
class Val implements ValInterface
{


    public function minlength(string $data, int $length)
    {
        if (strlen($data) < $length) {
            return " (** minlength **) Your string " . $data . " can only be " . $length . " long";
        }
    }

    public function maxlength(string $data, int $length)
    {

        if (strlen($data) > $length) {

            return " (** maxlength **) Your string " . $data . " can only be " . $length . " long";
        }
    }

    public function digit(string $data)
    {
        if ( false == ctype_digit($data) ) {
            return "Your string " . $data . " must be a digit";
        }
    }

    public function __call(string $name, $arguments)
    {
        throw new \Exception("$name does not exist inside of: " . __CLASS__);
    }

    public function isValidLenght(string $lenght, string $data, int $length)
    {
        if ($this->{$lenght}($data, $length)) {
            return $this->{$lenght}($data, $length);
        }

    }

}
