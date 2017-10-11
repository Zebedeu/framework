<?php

namespace Ballybran\Helpers\Images\Interface;

interface ImageInterface {

    public function save($file, $quality);

    public function resize($width = 0, $heigth = 0, $default = '');
}
