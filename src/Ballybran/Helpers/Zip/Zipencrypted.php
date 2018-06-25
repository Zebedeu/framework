<?php
/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 04/05/18
 * Time: 09:07
 */

namespace Ballybran\Helpers\Zip;


class Zipencrypted {

    static function isEncryptedZip( $pathToArchive ) {
        $fp = @fopen( $pathToArchive, 'r' );
        $encrypted = false;
        if ( $fp && fseek( $fp, 6 ) == 0 ) {
            $string = fread( $fp, 2 );
            if ( false !== $string ) {
                $data = unpack("vgeneral", $string);
                $encrypted = $data[ 'general' ] & 0x01 ? true : false;
            }
            fclose( $fp );
        }
        return $encrypted;
    }
}