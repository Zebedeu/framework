<?php

/**
 * knut7 Framework (http://framework.artphoweb.com/)
 * knut7 FW(tm) : Rapid Development Framework (http://framework.artphoweb.com/)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @link      http://github.com/zebedeu/artphoweb for the canonical source repository
 * Copyright (c) 2017.  knut7  Software Technologies AO Inc. (http://www.artphoweb.com)
 * @license   http://framework.artphoweb.com/license/new-bsd New BSD License
 * @author    Marcio Zebedeu - artphoweb@artphoweb.com
 * @version   1.0.0
 */
namespace Ballybran\Helpers\Security;


class Val
{


    public function minlength(string $data, int $arg)
    {
        if (strlen($data) < $arg) {
            return "Your string can only be $arg long";
        }
    }

    public function maxlength(string $data, int $arg)
    {
        if (strlen($data) > $arg) {
            return "Your string can only be $arg long";
        }
    }

    public function digit(string $data)
    {
        if (ctype_digit($data) == false) {
            return "Your string must be a digit";
        }
    }

    public function __call(string $name, $arguments)
    {
        throw new \Exception("$name does not exist inside of: " . __CLASS__);
    }

}