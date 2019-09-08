<?php
/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 20/01/18
 * Time: 09:27
 */

namespace Ballybran\Helpers\Http;


class NoFilesException extends \RuntimeException
{


    public function __construct(string $d)
    {
        echo $d;
    }
}