<?php
/**
 * KNUT7 K7F (https://marciozebedeu.com/)
 * KNUT7 K7F (tm) : Rapid Development Framework (https://marciozebedeu.com/).
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @see      https://github.com/knut7/framework/ for the canonical source repository
 *
 * @copyright (c) 2015.  KNUT7  Software Technologies AO Inc. (https://marciozebedeu.com/)
 * @license   https://marciozebedeu.com/license/new-bsd New BSD License
 * @author    Marcio Zebedeu - artphoweb@artphoweb.com
 *
 * @version   1.0.2
 */

namespace Ballybran\Helpers\Zip;
use Ballybran\Exception\Exception;

class HZip extends ZipStatus
{
    private $zip;

    public function __construct($objec = null)
    {
        if (is_object($objec)) {
            $this->zip = $objec;
        } else {
            $this->zip = new \ZipArchive();
        }
    }

    /**
     * _rglobRead.
     *
     * @param mixed $source
     * @param mixed $array
     */
    private function _rglobRead($source, &$array = array())
    {
        if (!$source || trim($source) == '') {
            $source = '.';
        }

        foreach ((array)glob($source . '/*/') as $key => $value) {
            $this->_rglobRead(str_replace('//', '/', $value), $array);
        }

        foreach ((array)glob($source . '*.*') as $key => $value) {
            $array[] = str_replace('//', '/', $value);
        }
    }

    /**
     * _zip.
     *
     * @param mixed $array
     * @param mixed $part
     * @param mixed $destination
     */
    private function _zip($array, $part, $destination)
    {
        @mkdir($destination, 0777, true);

        if ($this->zip->open(str_replace('//', '/', "{$destination}/partz{$part}.zip"), \ZipArchive::CREATE)) {
            foreach ((array)$array as $key => $value) {
                $this->zip->addFile($value, str_replace(array('../', './'), null, $value));
            }
            $this->ZipStatusString($this->zip->status);
            $this->zip->close();
        }
    }

    /**
     * create.
     *
     * @param mixed $limit
     * @param mixed $source
     * @param mixed $destination
     */
    public function create($limit = 500, $source = null, $destination = './')
    {
        if (!$destination || trim($destination) == '') {
            $destination = './';
        }

        $this->_rglobRead($source, $input);
        $maxinput = count($input);
        $splitinto = (($maxinput / $limit) > round($maxinput / $limit, 0)) ? round($maxinput / $limit, 0) + 1 : round($maxinput / $limit, 0);

        for ($i = 0; $i < $splitinto; ++$i) {
            $this->_zip(array_slice($input, ($i * $limit), $limit, true), $i, $destination);
        }

        unset($input);

        return;
    }

    /**
     * unzip.
     *
     * @param mixed $source
     * @param mixed $destination
     */
    public function unzip($source, $destination)
    {
        @mkdir($destination, 0777, true);

        foreach ((array)glob($source . '/*.zip') as $key => $value) {
            if ($this->zip->open(str_replace('//', '/', $value)) === true) {
                $this->zip->extractTo($destination);
                echo $this->ZipStatusString($this->zip);
                $this->zip->close();
            }
        }
    }

    /**
     * deleteZip.
     *
     * @param mixed $zipname
     */
    public function deleteZip($zipname)
    {
        if (!file_exists($zipname)) {
            try {
                throw new Exception('no file zip');
            } catch (\Exception $e) {
                $e->getMessage();
            }
        }
        @chmod($zipname, 0777);

        if (!$this->zip->open($zipname)) {
        }

        $loop = $this->zip->numFiles;

        if (!$loop) {
            try {
                throw new Exception('no file zip');
            } catch (\Exception $e) {
                $e->getMessage();
            }
        }
        for ($i = 0; $i < $loop; ++$i) {
            $this->zip->deleteIndex($i);
        }
    }
}
