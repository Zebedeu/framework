<?php
/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 19/01/18
 * Time: 17:03
 */

namespace Ballybran\Helpers\Images;


use Ballybran\Helpers\Images\ImageInterface\ResizeInterface;
use Ballybran\Helpers\Images\ImageInterface\RotateImage;


class Rotate implements RotateImage
{


    /**
     * @var int
     */
    private $degree;
    /**
     * @var string
     */
    private $color;


    function __construct(int $degree , $color = '000000')
    {

        $this->degree = $degree;
        $this->color = $color;
        $this->imageRotate($degree , $color);

    }

    public function imageRotate(int $degree , $color = '000000')
    {
        $rgb = $this->html2rgb($color);

        $this->image = imagerotate($this->image , $degree , imagecolorallocate($this->image , $rgb[0] , $rgb[1] , $rgb[2]));

        $this->width = imagesx($this->image);
        $this->height = imagesy($this->image);

    }

    private function html2rgb($color)
    {
        if ($color[0] == '#') {
            $color = substr($color , 1);
        }

        if (strlen($color) == 6) {
            list($r , $g , $b) = array($color[0] . $color[1] , $color[2] . $color[3] , $color[4] . $color[5]);
        } elseif (strlen($color) == 3) {
            list($r , $g , $b) = array($color[0] . $color[0] , $color[1] . $color[1] , $color[2] . $color[2]);
        } else {
            return false;
        }

        $r = hexdec($r);
        $g = hexdec($g);
        $b = hexdec($b);

        return array($r , $g , $b);
    }

    private function text($text , $x = 0 , $y = 0 , $size = 5 , $color = '000000')
    {
        $rgb = $this->html2rgb($color);

        imagestring($this->image , $size , $x , $y , $text , imagecolorallocate($this->image , $rgb[0] , $rgb[1] , $rgb[2]));
    }


}