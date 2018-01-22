<?php
/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 21/01/18
 * Time: 09:05
 */

namespace Ballybran\Helpers\Images\ImageInterface;


interface RotateImage
{
    public function imageRotate(int $degree,   $colorHexType = '000000');


}