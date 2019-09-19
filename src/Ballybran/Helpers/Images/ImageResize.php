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

namespace Ballybran\Helpers\Images;


use Ballybran\Helpers\Images\ImageInterface\ResizeInterface;

class ImageResize implements ResizeInterface
{


    private $file;
    private $image;
    private $width;

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @return resource
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return mixed
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return mixed
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @return mixed
     */
    public function getBits()
    {
        return $this->bits;
    }

    /**
     * @return mixed
     */
    public function getMime()
    {
        return $this->mime;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @param resource $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @param mixed $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * @param mixed $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }

    /**
     * @param string $bits
     */
    public function setBits(string $bits)
    {
        $this->bits = $bits;
    }

    /**
     * @param string $mime
     */
    public function setMime(string $mime)
    {
        $this->mime = $mime;
    }

    private $height;
    private $bits;
    private $mime;

    public function upload($file)
    {
        if (file_exists($file)) {
            $this->file = $file;

            $info = getimagesize($file);

            $this->setWidth($info[0]);
            $this->setHeight($info[1]);
            $this->setBits(isset($info['bits']) ? $info['bits'] : '');
            $this->setMime(isset($info['mime']) ? $info['mime'] : '');

            if ($this->getMime() == 'image/gif') {
                $this->image = imagecreatefromgif($file);
                $this->setImage($this->image);
            } elseif ($this->mime == 'image/png') {
                $this->image = imagecreatefrompng($file);
                $this->setImage($this->image);

            } elseif ($this->mime == 'image/jpeg') {
                $this->image = imagecreatefromjpeg($file);
                $this->setImage($this->image);

            }
        } else {
            exit('Error: Could not load image ' . $file . '!');
        }
    }


    /**
     *
     * @param type $file Inser you file
     * @param type $quality Isert optional quality for image
     * Exemple save('exemple.jpg, 100);
     */
    public function save(string $savePath, int $imageQuality = 100)
    {
        $info = pathinfo($savePath);

        $extension = strtolower($info['extension']);

        if (is_resource($this->image)) {
            if ($extension == 'jpeg' || $extension == 'jpg') {
                imagejpeg($this->image, $savePath, $imageQuality);
            } elseif ($extension == 'png') {
                imagepng($this->image, $savePath);
            } elseif ($extension == 'gif') {
                imagegif($this->image, $savePath);
            }

            imagedestroy($this->image);
        }
    }

    /**
     *
     * @param type $width Inser Width for you image
     * @param type $height Inser height for you image
     * @param type $default nser you scale (where w = width end h = height)
     * @return type
     * Exemplae: resize(800, 600, 'w');
     */
    public function resizeImage($width = 0, $height = 0, $option = 'auto')
    {
        if (!$this->width || !$this->height) {
            return;
        }

        $xpos = 0;
        $ypos = 0;
        $scale = 1;

        $scale_w = $width / $this->width;
        $scale_h = $height / $this->height;

        if ($option == 'w') {
            $scale = $scale_w;
        } elseif ($option == 'h') {
            $scale = $scale_h;
        } else {
            $scale = min($scale_w, $scale_h);
        }

        if ($scale == 1 && $scale_h == $scale_w && $this->mime != 'image/png') {
            return;
        }

        $new_width = (int)($this->width * $scale);
        $new_height = (int)($this->height * $scale);
        $xpos = (int)(($width - $new_width) / 2);
        $ypos = (int)(($height - $new_height) / 2);

        $image_old = $this->image;
        $this->image = imagecreatetruecolor($width, $height);

        if ($this->mime == 'image/png') {
            imagealphablending($this->image, false);
            imagesavealpha($this->image, true);
            $background = imagecolorallocatealpha($this->image, 255, 255, 255, 127);
            imagecolortransparent($this->image, $background);
        } else {
            $background = imagecolorallocate($this->image, 255, 255, 255);
        }

        imagefilledrectangle($this->image, 0, 0, $width, $height, $background);

        imagecopyresampled($this->image, $image_old, $xpos, $ypos, 0, 0, $new_width, $new_height, $this->width, $this->height);
        imagedestroy($image_old);

        $this->width = $width;
        $this->height = $height;
    }


    public function crop($top_x, $top_y, $bottom_x, $bottom_y)
    {
        $image_old = $this->image;
        $this->image = imagecreatetruecolor($bottom_x - $top_x, $bottom_y - $top_y);

        imagecopy($this->image, $image_old, 0, 0, $top_x, $top_y, $this->width, $this->height);
        imagedestroy($image_old);

        $this->width = $bottom_x - $top_x;
        $this->height = $bottom_y - $top_y;
    }

    public function imageRotate(int $degree, $color = '000000')
    {

        $rgb = $this->html2rgb($color);

        $this->image = imagerotate($this->image, $degree, imagecolorallocate($this->image, $rgb[0], $rgb[1], $rgb[2]));

        $this->width = imagesx($this->image);
        $this->height = imagesy($this->image);
    }


    /**
     *
     * @param type $watermark
     * @param type $position
     */
    public function watermark($watermark, $position = 'bottomright')
    {
        $watermark = imagecreatefromjpeg('DDDDD');

        switch ($position) {
            case 'topleft':
                $watermark_pos_x = 0;
                $watermark_pos_y = 0;
                break;
            case 'topright':
                $watermark_pos_x = $this->width - 10;
                $watermark_pos_y = 0;
                break;
            case 'bottomleft':
                $watermark_pos_x = 0;
                $watermark_pos_y = $this->height - 10;
                break;
            case 'bottomright':
                $watermark_pos_x = $this->width - 5;
                $watermark_pos_y = $this->height - 5;
                break;
        }

        imagecopy($this->image, $watermark, $watermark_pos_x, $watermark_pos_y, 0, 0, $this->getWidth(), $this->getHeight());

        imagedestroy($watermark);
    }

    private function filter()
    {
        $args = func_get_args();

        call_user_func_array('imagefilter', $args);
    }

    private function text($text, $x = 0, $y = 0, $size = 5, $color = '000000')
    {
        $rgb = $this->html2rgb($color);

        imagestring($this->image, $size, $x, $y, $text, imagecolorallocate($this->image, $rgb[0], $rgb[1], $rgb[2]));
    }

    private function merge($merge, $x = 0, $y = 0, $opacity = 100)
    {
        imagecopymerge($this->image, $this->getImage(), $x, $y, 0, 0, $this->getWidth(), $this->getHeight(), $opacity);
    }

    private function html2rgb($color)
    {
        if ($color[0] == '#') {
            $color = substr($color, 1);
        }

        if (strlen($color) == 6) {
            list($r, $g, $b) = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
        } elseif (strlen($color) == 3) {
            list($r, $g, $b) = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
        } else {
            return false;
        }

        $r = hexdec($r);
        $g = hexdec($g);
        $b = hexdec($b);

        return array($r, $g, $b);
    }

}
