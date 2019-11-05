<?php
/**
 * KNUT7 K7F (https://marciozebedeu.com/)
 * KNUT7 K7F (tm) : Rapid Development Framework (https://marciozebedeu.com/)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @link      https://github.com/knut7/framework/ for the canonical source repository
 * @copyright (c) 2015.  KNUT7  Software Technologies AO Inc. (https://marciozebedeu.com/)
 * @license   https://marciozebedeu.com/license/new-bsd New BSD License
 * @author    Marcio Zebedeu - artphoweb@artphoweb.com
 * @version   1.0.2
 */

namespace Ballybran\Helpers\Images;

class Image2
{

    private $filename;

    public function __construct($file)
    {
        $this->filename = $file;
    }

    public function resize($width, $height)
    {
        if (!is_file(DIR_FILE . $this->filename)) {
            return;
        }

        $extension = pathinfo($this->filename, PATHINFO_EXTENSION);

        $old_image = $this->filename;
        $new_image = 'cache/' . utf8_substr($this->filename, 0, utf8_strrpos($this->filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;

        if (!is_file(DIR_FILE . $new_image) || (filectime(DIR_FILE . $old_image) > filectime(DIR_FILE . $new_image))) {
            $path = '';

            $directories = explode('/', dirname(str_replace('../', '', $new_image)));

            foreach ($directories as $directory) {
                $path = $path . '/' . $directory;

                if (!is_dir(DIR_FILE . $path)) {
                    @mkdir(DIR_FILE . $path, 0777);
                }
            }

            list($width_orig, $height_orig) = getimagesize(DIR_FILE . $old_image);

            if ($width_orig != $width || $height_orig != $height) {
                $image = new Image(DIR_FILE . $old_image, $width, $height);
                $image->saveImage(DIR_FILE . $new_image);
            } else {
                copy(DIR_FILE . $old_image, DIR_FILE . $new_image);
            }
        }

        if ($this->request->server['HTTPS']) {
            return DIR_FILE . 'image/' . $new_image;
        } else {
            return DIR_FILE . 'image/' . $new_image;
        }
    }

}
