<?php


namespace Ballybran\Helpers\Stdlib;


use function PHPUnit\Framework\fileExists;

trait CreateFiles
{
    /**
     * @param $file
     */
    private function createWritableFolder($file)
    {
        $currPath = '';
        $path = explode( "/" , $file );
        $currPath .= trim( $path[0] );
        if($currPath != '.' && $currPath != '/' ) {
            @mkdir( DIR_STORAGE.$currPath , 0777 , true );
        }

    }
}