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

namespace Ballybran\Helpers\Http;

use Ballybran\Helpers\Images\Image;
use Ballybran\Helpers\Images\ImageInterface\ImageInterface;
use Ballybran\Helpers\Images\ImageInterface\ResizeInterface;
use Ballybran\Helpers\Security\Session;

/**
 * Class Uploads.
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
     * 
     * @var $userNamePath
     */
    public $userNamePath;

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
     *
     * @param ImageInterface $image
     */
    public function __construct(ResizeInterface $image, string $filename = 'archive')
    {
        if (!empty($_FILES[$filename])) {
            if(is_array( $_FILES[$filename]['name'])){
            foreach ($_FILES[$filename]['name'] as $i => $name) {
                $this->name = $_FILES[$filename]['name'][$i];
                $this->size = $_FILES[$filename]['size'][$i];
                $this->type = $_FILES[$filename]['type'][$i];
                $this->tmp = $_FILES[$filename]['tmp_name'][$i];

                $this->explode = explode('.', $this->name);
            }
            }else {
                $this->name = $_FILES[$filename]['name'];
                $this->size = $_FILES[$filename]['size'];
                $this->type = $_FILES[$filename]['type'];
                $this->tmp = $_FILES[$filename]['tmp_name'];
                $this->explode = explode('.', $this->name);

            }

            $this->image = $image;
        }
    }

    /**
     * 
     * @param string $dir
     * 
     * make PathDir If User Exist
     * @param string $userNamePath
     */
    public function file($dir_name = null, $userNamePath= null)
    {
        $this->dir = $dir_name;
        $this->userNamePath = $userNamePath;

        $this->make();
    }

    /**
     * @return string
     */
    private function make()
    {
        if ( null == $this->userNamePath ) {
            $this->makeDefaultPath();
            $this->makePathDirIfDefaultFileNotExist();
            return $this->moveUploadedFile();
        }

        $this->makePathBayUserName();
        $this->makePathDirIfUserExist();
        $this->moveUploadedFile();
    }

    private function makePathDirIfUserExist()
    {
        if (!file_exists(DIR_FILE . 'Upload' . DS . $this->userNamePath . DS . $this->dir . DS)) {
            mkdir(DIR_FILE . 'Upload' . DS . $this->userNamePath . DS . $this->dir . DS, 0777, true);
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

    /**
     * Move Upload File
     * @return void
     */
    private function moveUploadedFile()
    {
        if (empty($this->tmp)) {
            throw new NoFilesException('No uploaded files were found. Did you specify "enctype" in your &lt;form&gt; tag?');
        }
        if (move_uploaded_file($this->tmp, $this->path)) {
            echo $this->getObjectImage();
        }
    }

    /**
     * Make Defaukt Path
     * @return string - upload archive
     *
     */
    private function makeDefaultPath(): String
    {
        return $this->path = DIR_FILE . 'Upload' . DS . 'Default' . DS . $this->dir . DS;
    }

    /**
     * make Path Bay User Name
     * @return string -
     */
    private function makePathBayUserName(): String
    {
        $this->ext = end($this->explode);
        $this->path = DIR_FILE . 'Upload' . $this->userNamePath . DS . $this->dir . DS;
        $this->path .= basename($this->explode[0] . time() . '.' . $this->ext);

        return $this->path;
    }
}
