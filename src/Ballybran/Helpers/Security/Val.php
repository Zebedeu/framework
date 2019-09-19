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
        if (ctype_digit($data) == false) {
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
