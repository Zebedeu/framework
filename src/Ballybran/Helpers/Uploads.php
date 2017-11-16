<?php

/**
 * APWEB Framework (http://framework.artphoweb.com/)
 * APWEB FW(tm) : Rapid Development Framework (http://framework.artphoweb.com/)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @link      http://github.com/zebedeu/artphoweb for the canonical source repository
 * @copyright (c) 2015.  APWEB  Software Technologies AO Inc. (http://www.artphoweb.com)
 * @license   http://framework.artphoweb.com/license/new-bsd New BSD License
 * @author    Marcio Zebedeu - artphoweb@artphoweb.com
 * @version   1.0.0
 */

namespace Ballybran\Helpers;


use Ballybran\Helpers\Images\Image;
use Ballybran\Helpers\Security\Session;
use Ballybran\Helpers\vardump\Vardump;

/**
 * Class Uploads
 * @package Ballybran\Helpers
 */
class Uploads
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
    private $ext;
    private $dir;

    /**
     * @return mixed
     */
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
     */
    function __construct()
    {

        if (isset($_FILES['archive'])) {

            foreach ($_FILES['archive']['name'] as $i => $name) {
                $this->name = $_FILES['archive']['name'][$i];
                $this->size = $_FILES['archive']['size'][$i];
                $this->type = $_FILES['archive']['type'][$i];
                $this->tmp = $_FILES['archive']['tmp_name'][$i];

                $this->explode = explode('.', $name);

            }
        }
    }

    /**
     * @param null $dir
     * @return string
     */
    public function file($dir = null)
    {
        if (null == $dir) {
            return $this->isValid();
        }

        $this->ext = end($this->explode);
        if (!Session::exist()) {

            $this->path = DIR_FILE . 'Upload' . DS . 'Default' . DS . $this->dir . DS;
        }
        $this->path = DIR_FILE . 'Upload' . DS . Session::get('U_NAME') . DS . $this->dir . DS;

        $this->path .= basename($this->explode[0] . time() . '.' . $this->ext);

        // echo $ext . "<br/>";


        if (empty($this->isValid())) {
            return $this->isValid();
        }

        if (Session::exist() && !file_exists(DIR_FILE . 'Upload' . DS . Session::get('U_NAME') . DS . $this->dir . DS)) {
            mkdir(DIR_FILE . 'Upload' . DS . Session::get('U_NAME') . DS . $this->dir . DS, 0777, true);

        }  // chmod('uploads/', 0755);
        if (!file_exists(DIR_FILE . 'Upload' . DS . 'Default' . DS . $this->dir . DS)) {
            mkdir(DIR_FILE . 'Upload' . DS . 'Default' . DS . $this->dir . DS, 0777, true);

        }  // chmod('uploads/', 0755);
        return $this->move_upload();

    }



    private function isValid()
    {
        if(empty($this->dir)) {
            return $errors[] = '<div class="btn btn-danger"> sem diretorio</div>';

        }
        if (empty($this->type)) {
            return $errors[] = '<div class="btn btn-danger"> Por favor, escolhe 1 ficheiro para ser carregado</div>';
        }


        $allowed = array('jpg', 'JPG', 'jpeg', 'gif', 'btm', 'png', 'txt', 'docx', 'doc', 'pdf', 'mp3');

        if (in_array($this->ext, $allowed) === false)
            return $errors[] = '<div class="btn btn-danger">A extensao do ficheiro nao foi permitido </div>';

//                              100000000
        $max_size = 100000000;
        if ($this->size > $max_size) {
            return $errors[] = '<div class="btn btn-danger"> O tamanho do ficheiro é muito grande</div>';
        }
    }// end foreach


    /**
     *
     */
    private function getObjectImage()
    {

        $img = new Image($this->path, $this->getWidth(), $this->getHeight(), $this->getOption());
        $img->saveImage($this->path, $this->getQuality());
    }


    /**
     * @return string
     */
    private function move_upload()
    {

        if (move_uploaded_file($this->tmp, $this->path)) {
            $this->getObjectImage();

            $output = '<div class="btn btn-success">';
            $output .= 'Ficheiro carregado  com sucesso';
            $output .= '</div>';
            return $output;
        }
            $output = '<div class="btn btn-warning">';
            $output .= 'Nenhum ficheiro foi carregado';
            $output .= '</div>';
            return $output;

    }

}