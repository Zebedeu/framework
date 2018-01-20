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

namespace Ballybran\Helpers;


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
class FileSystem
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
    private $width;
    /**
     * @var
     */
    private $height;

    /**
     * @var
     */
    private $quality;


    /**
     * @var
     */
    private $option;
    /**
     * @var
     */
    private $ext;
    /**
     * @var
     */
    private $dir;


    /**
     * @var
     */
    private $degree= 0;

    private $color;
    /**
     * @var Image
     */
    private $image;

    /**
     * @return mixed
     */
    public function getDegree() : int
    {
        return $this->degree;
    }

    /**
     * @param mixed $degree
     */
    public function setDegree(int $degree)
    {
        $this->degree = $degree;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param mixed $color
     */
    public function setColor( $color =  "000000")
    {
        $this->color = $color;
    }
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param mixed $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * @return mixed
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param mixed $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }

    /**
     * @return mixed
     */
    public function getQuality()
    {
        return $this->quality;
    }

    /**
     * @param mixed $quality
     */
    public function setQuality($quality)
    {
        $this->quality = $quality;
    }


    /**
     * @return mixed
     */
    public function getOption()
    {
        return $this->option;
    }

    /**
     * @param mixed $option
     */
    public function setOption($option)
    {
        $this->option = $option;
    }


    /**
     * Uploads constructor.
     * @param ImageInterface $image
     */
    function __construct(ResizeInterface $image)
    {

        var_dump($_FILES['archive']);

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
        $this->image->resizes($this->getWidth(), $this->getHeight(), $this->getOption());
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

    private function makeDefaultPath()
    {
        $this->path = DIR_FILE . 'Upload' . DS . 'Default' . DS . $this->dir . DS;
    }

    private function makePathBayUserName()
    {
        $this->ext = end($this->explode);
        $this->path = DIR_FILE . 'Upload' . DS . Session::get('U_NAME') . DS . $this->dir . DS;
        $this->path .= basename($this->explode[0] . time() . '.' . $this->ext);
    }

}