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
namespace  Ballybran\Helpers\Images;



class Image extends Resize   {


    /**
     * Image constructor.
     * @param $filename
     * @param $new_width
     * @param $new_height
     * @param string $options
     */
    public function __construct($filename, $new_width, $new_height, $options = "auto") {

        parent::__construct($filename);

        $this->crops($new_width, $new_height, $options);
    }


    public  function crops($new_width, $new_height, $options) {

        $this->resizeImage($new_width, $new_height, $options);
    }

}
