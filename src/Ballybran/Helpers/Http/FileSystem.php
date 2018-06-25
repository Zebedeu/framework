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


use Ballybran\Helpers\Images\Image;
use Ballybran\Helpers\Images\ImageInterface\ImageInterface;
use Ballybran\Helpers\Images\ImageInterface\ResizeInterface;
use Ballybran\Helpers\Images\Resize;
use Ballybran\Helpers\Security\Session;
use Ballybran\Helpers\vardump\Vardump;

/**
 * Class Uploads
 * @package Ballybran\Helpers
 */
class FileSystem extends ImageProperties
{


    /**
     * @var
     */
    public $path;
    /**
     * @var
     */
    private $tmp;
    /**
     * @var
     */
    public $name;
    /**
     * @var
     */
    public $size;
    /**
     * @var
     */
    public $type;
    /**
     * @var array
     */
    private $explode;

    /**
     * @var
     */
    private $ext;
    /**
     * @var
     */
    private $dir;

    /**
     * @var Image
     */
    private $image;

    /**
     * @return mixed
     */

    private $text;

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * Uploads constructor.
     * @param ImageInterface $image
     */
    function __construct(ResizeInterface $image)
    {


        if (!empty($_FILES['archive'])) {

            foreach ($_FILES['archive']['name'] as $i => $name) {
                $this->name = $_FILES['archive']['name'][$i];
                $this->size = $_FILES['archive']['size'][$i];
                $this->type = $_FILES['archive']['type'][$i];
                $this->tmp = $_FILES['archive']['tmp_name'][$i];

                $this->explode = explode('.', $this->name);
            }
        }



        $this->image = $image;
    }


    /**
     * @param null $dir
     */
    public function file($dir_name = null)
    {
        $this->dir = $dir_name;

        $this->make();
    }

    /**
     * @return string
     */
    private function make()
    {

        if (!Session::exist()) {

            $this->makeDefaultPath();
            $this->makePathDirIfDefaultFileNotExist();
            return $this->moveUploadedFile();
        }

        $this->makePathBayUserName();
        $this->makePathDirIfUserExist();
        return $this->moveUploadedFile();

    }

    private function makePathDirIfUserExist()
    {
        if (!file_exists(DIR_FILE . 'Upload' . DS . Session::get('U_NAME') . DS . $this->dir . DS)) {
            mkdir(DIR_FILE . 'Upload' . DS . Session::get('U_NAME') . DS . $this->dir . DS, 0777, true);
        }

    }

    private function makePathDirIfDefaultFileNotExist()
    {

        if (!file_exists(DIR_FILE . 'Upload' . DS . 'Default' . DS . $this->dir . DS)) {
            mkdir(DIR_FILE . 'Upload' . DS . 'Default' . DS . $this->dir . DS, 0777, true);

        }
    }

    private function getObjectImage()
    {

        $this->image->upload($this->path);
        $this->image->imageRotate($this->getDegree(), $this->getColor());
        $this->image->resizeImage($this->getWidth(), $this->getHeight(), $this->getOption());
        $this->image->save($this->path, $this->getQuality());

    }
    private function moveUploadedFile()
    {
        if(empty($this->tmp)) {
            throw new NoFilesException('No uploaded files were found. Did you specify "enctype" in your &lt;form&gt; tag?');
        }
       if(move_uploaded_file($this->tmp, $this->path)) {
        $this->getObjectImage();
       }

    }

    private function makeDefaultPath() : String
    {
        return $this->path = DIR_FILE . 'Upload' . DS . 'Default' . DS . $this->dir . DS;
    }

    private function makePathBayUserName() : String
    {
        $this->ext = end($this->explode);
        $this->path = DIR_FILE . 'Upload' . DS . Session::get('U_NAME') . DS . $this->dir . DS;
        $this->path .= basename($this->explode[0] . time() . '.' . $this->ext);
        return $this->path;
    }



}