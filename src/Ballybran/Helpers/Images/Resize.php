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

class Resize implements ResizeInterface
{


    private $image;
    private $width;
    private $height;
    private $imageResized;

    public function upload($file)
    {

        // *** Open up the file
        $this->image = $this->openImage($file);

        // Get Width  and Height
        $this->width = imagesx($this->image);
        $this->height = imagesy($this->image);
    }

    private function openImage($file)
    {
        //*** get extendsion
        $extension = strtolower(strrchr($file, '.'));

        switch ($extension) {
            case '.jpg':
            case '.jpeg':

                $img = imagecreatefromjpeg($file);
                break;
            case '.gif':
                $img = imagecreatefromgif($file);
                break;
            case '.png':
                $img = imagecreatefrompng($file);
                break;

            default:
                $img = false;
                break;
        }

        return $img;
    }

    public function resizeImage($width, $height, $option = "auto")
    {
        $optionaArray = $this->getDimensions($width, $height, strtolower($option));

        // *** Get optional witdth and height - based on option
        $optionalWidth = $optionaArray['optionalWidth'];
        $optionalHeight = $optionaArray['optionalHeight'];

        $this->imageResized = imagecreatetruecolor($optionalWidth, $optionalHeight);

        // ***  Resample - create image canvas of x, y size

        imagecopyresampled($this->imageResized, $this->image, 0, 0, 0, 0, $optionalWidth, $optionalHeight, $this->width, $this->height);

        if ($option == 'crop') {
            $this->crop($optionalWidth, $optionalHeight, $width, $height);
        }
    }

    private function getDimensions($new_width, $new_height, $option)
    {
        $optionalWidth = "";
        $optionalHeight = "";

        switch ($option) {
            case 'exact':
                $optionalWidth = $new_width;
                $optionalHeight = $new_height;
                break;
            case 'portrait':
                $optionalWidth = $this->getSizeByFixedHeight($new_height);
                $optionalHeight = $new_width;
                break;
            case 'lendscape':
                $optionalWidth = $new_width;
                $optionalHeight = $this->getSizeByFixedWidth($new_width);
                break;
            case 'auto':
                $optionaArray = $this->getSizeByAuto($new_width, $new_height);
                $optionalWidth = $optionaArray['optionalWidth'];
                $optionalHeight = $optionaArray['optionalHeight'];
                break;
            case 'crop':
                $optionaArray = $this->getOptionalCrop($new_width, $new_height);
                $optionalWidth = $optionaArray['optionalWidth'];
                $optionalHeight = $optionaArray['optionalHeight'];
                break;
            case 'perfil':
                $optionaArray = $this->getOptionalPerfil($new_width, $new_height);
                $optionalWidth = $optionaArray['optionalWidth'];
                $optionalHeight = $optionaArray['optionalHeight'];
        }

        return array('optionalWidth' => $optionalWidth, 'optionalHeight' => $optionalHeight);
    }

    private function getOptionalPerfil($new_width, $new_height)
    {
        $heightRatio = $new_height;
        $widthRatio = $new_width;

        if (!$heightRatio < $widthRatio) {
            $optionalRatio = $heightRatio;
        }
        $optionalRatio = $widthRatio;
        $optionalHeight = $optionalRatio;
        $optionalWidth = $heightRatio;
        return array('optionalWidth' => $optionalWidth, 'optionalHeight' => $optionalHeight);

    }

    private function getSizeByFixedHeight($new_height)
    {
        $ratio = $this->width / $this->height;
        $new_width = $new_height * $ratio;
        return $new_width;
    }

    private function getSizeByFixedWidth($new_width)
    {
        $ratio = $this->height / $this->width;
        $new_height = $new_width * $ratio;
        return $new_height;
    }

    private function getSizeByAuto($new_width, $new_height)
    {

        if ($this->height < $this->width) {
            // *** image to be resized is taller (landscap)

            $optionalWidth = $new_width;
            $optionalHeight = $this->getSizeByFixedWidth($new_width);
        } elseif ($this->height > $this->width) {
            // *** image to be resized is taller (portrait)

            $optionalWidth = $this->getSizeByFixedHeight($new_height);
            $optionalHeight = $new_height;
        } else {

            // *** image to be Resized is a square
            if ($new_height < $new_width) {
                $optionalWidth = $new_width;
                $optionalHeight = $this->getSizeByFixedWidth($new_width);
            } else if ($new_height > $new_width) {
                $optionalWidth = $this->getSizeByFixedHeight($new_height);
                $optionalHeight = $new_height;
            } else {
                $optionalWidth = $new_width;
                $optionalHeight = $new_height;
            }
        }
        return array('optionalWidth' => $optionalWidth, 'optionalHeight' => $optionalHeight);
    }

    /**
     * @param $new_width
     * @param $new_height
     * @return array
     *  example  w = 512, h = 720 if 720 / 200 < 512 / 400
     */
    private function getOptionalCrop(int $new_width, int $new_height): array
    {
        $heightRatio = $this->height / $new_height;
        $widthRatio = $this->width / $new_width;

        if (!$heightRatio < $widthRatio) {
            $optionalRatio = $heightRatio;
        }
        $optionalRatio = $widthRatio;
        $optionalHeight = $this->height / $optionalRatio;
        $optionalWidth = $this->width / $optionalRatio;
        return array('optionalWidth' => $optionalWidth, 'optionalHeight' => $optionalHeight);
    }

    private function crop($optionalWidth, $optionalHeight, $new_width, $new_height)
    {
// *** find center - this will be used for the crop
        $cropStartX = ($optionalWidth / 2) - ($new_width / 2);
        $cropStartY = ($optionalHeight / 2) - ($new_height / 2);

        $crop = $this->imageResized;
        // imageDestroy($this->imageResçized);
        // *** Now crop from center to exact requested size

        $this->imageResized = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($this->imageResized, $crop, 0, 0, $cropStartX, $cropStartY, $new_width, $new_height, $new_width, $new_height);
    }

    public function save(string $savePath, int $imageQuality = 100)
    {
        // *** Get extension

        $extension = strrchr($savePath, '.');
        $extension = strtolower($extension);

        switch ($extension) {
            case '.jpg':
            case '.jpeg':
                if (exif_imagetype($savePath) && imagetypes() & IMG_JPG) {
                    imagejpeg($this->imageResized, $savePath, $imageQuality);
                }
                break;

            case '.gif':
                if (exif_imagetype($savePath) && imagetypes() & IMG_GIF) {
                    imagegif($this->imageResized, $savePath);
                }
                break;

            case '.png':

                // *** scale quality from 0-100 to 0-9
                $scaleQuality = round(($imageQuality / 100) * 9);

                $invertScaleQuality = 9 - $scaleQuality;

                if (exif_imagetype($savePath) && imagetypes() & IMG_PNG) {

                    imagepng($this->imageResized, $savePath, $invertScaleQuality);
                }
                break;

            // .... etc
            default:
                // *** No extension - No Save
                echo "no save";
                break;
        }
        imagedestroy($this->imageResized);
    }

    public function imageRotate(int $degree, $colorHexType = '000000')
    {
        $rgb = $this->html2rgb($colorHexType);

        $this->image = imagerotate($this->image, $degree, imagecolorallocate($this->image, $rgb[0], $rgb[1], $rgb[2]));

        $this->width = imagesx($this->image);
        $this->height = imagesy($this->image);

    }

    private function html2rgb($color): array
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

    public function text($text, $x = 0, $y = 0, $size = 5, $color = '000000')
    {
        $rgb = $this->html2rgb($color);

        return imagestring($this->image, $size, $x, $y, $text, imagecolorallocate($this->image, $rgb[0], $rgb[1], $rgb[2]));
    }

}
