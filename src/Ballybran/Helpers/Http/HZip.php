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


namespace Ballybran\Helpers\Http;



use Ballybran\Exception\Exception;
use Ballybran\Exception\F7Exception;
use Ballybran\Helpers\Zip\ZipStatus;

class HZip extends ZipStatus {

    private $zip;
    public function __construct() {
        $this->zip = new \ZipArchive;


    }

    private function _rglobRead($source, &$array = array()) {
        if (!$source || trim($source) == "") {
            $source = ".";
        }

        foreach ((array) glob($source . "/*/") as $key => $value) {
            $this->_rglobRead(str_replace("//", "/", $value), $array);
        }

        foreach ((array) glob($source . "*.*") as $key => $value) {
            $array[] = str_replace("//", "/", $value);
        }
    }
    private function _zip($array, $part, $destination) {
        @mkdir($destination, 0777, true);

        if ($this->zip->open(str_replace("//", "/", "{$destination}/partz{$part}.zip"), \ZipArchive::CREATE)) {
            foreach ((array) $array as $key => $value) {
                $this->zip->addFile($value, str_replace(array("../", "./"), NULL, $value));
            }
            $this->zip->close();
        }
    }
    public function create($limit = 500, $source = NULL, $destination = "./") {


        if (!$destination || trim($destination) == "") {
            $destination = "./";
        }

        $this->_rglobRead($source, $input);
        $maxinput = count($input);
        $splitinto = (($maxinput / $limit) > round($maxinput / $limit, 0)) ? round($maxinput / $limit, 0) + 1 : round($maxinput / $limit, 0);

        for($i = 0; $i < $splitinto; $i ++) {
           $this->_zip(array_slice($input, ($i * $limit), $limit, true), $i, $destination);
        }

        unset($input);
        return;
    }
    public function unzip($source, $destination) {
        @mkdir($destination, 0777, true);

        foreach ((array) glob($source . "/*.zip") as $key => $value) {
            if ($this->zip->open(str_replace("//", "/", $value)) === true) {
                $this->zip->extractTo($destination);
                $this->zip->close();
            }
        }
    }

    public function deleteZip($zipname)
    {

        if(!file_exists($zipname)) {
             try{
                 throw new Exception("no file zip");
             }catch (\Exception $e) {
                 $e->getMessage();
             }

        }
        @chmod( $zipname, 0777 ) ;

        if (! $this->zip->open( $zipname ) ) {
        }

        $loop = $this->zip->numFiles ;

        if(!$loop ) {
            try{
                throw new Exception("no file zip");
            }catch (\Exception $e) {
                $e->getMessage();
            }        }
            for ( $i = 0; $i < $loop; $i++ )
            {

                $this->zip->deleteIndex( $i ) ;

            }


    }


    public function __destruct() {}
}
