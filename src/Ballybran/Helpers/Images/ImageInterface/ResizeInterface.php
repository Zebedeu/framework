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

namespace Ballybran\Helpers\Images\ImageInterface;

interface ResizeInterface
{

    public function upload($file);

    public function resizeImage($width, $height, $option = "auto");

    public function imageRotate(int $degree, $colorHexType = '000000');

    public function save(string $savePath, int $imageQuality = 100);

    public function text($text, $x = 0, $y = 0, $size = 5, $color = '000000');


}