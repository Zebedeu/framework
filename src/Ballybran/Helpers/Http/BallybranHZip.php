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

/**
 * Description of BallybranHZip
 * BallybranHZip::zipDir('/path/to/sourceDir', '/path/to/out.zip');
 * Class BallybranHZip
 * @package Ballybran\Helpers
 */
class BallybranHZip {

    /**
     *
     */
    private function addFile(){

    }

    /**
     * @param $folder
     * @param $zipFile
     * @param $length
     */
    private static function create($folder, &$zipFile, $length){
        
       $handle = opendir($folder);

       while (false !== $f = readdir($handle)) {
           if($f != '.' && $f != '..'){
            $filePath = "$folder/$f";

            $localPath = substr($filePath, $length);
                if(is_file($filePath)){
                    $zipFile->addFile($filePath, $localPath);
                    self::create($filePath, $zipFile, $length);
                }
            }
           }
           closedir($handle); 
    }

    /**
     * @param $sourcePath
     * @param $outZipPath
     */
    public static function zipDir($sourcePath, $outZipPath){
        $dirName = "";
        $pathInfo = pathinfo($sourcePath);
        $parentPath = $pathInfo['dirname'];
        /* @var $dirName type */
        $dirName = $pathInfo['basename'];

        $zip = new \ZipArchive();
        $zip->open($outZipPath, \ZipArchive::CREATE);
        $zip->addEmptyDir($dirName);

        self::create($sourcePath, $zip, strlen("$parentPath/"));
        $zip->close();
    }
}
