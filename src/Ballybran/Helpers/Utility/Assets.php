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

namespace Ballybran\Helpers\Utility;
/**
 * Class Assets
 * @package Ballybran\Helpers\Utility
 */
class Assets
{

    /**
     * @var array
     */
    protected static $templates = array(
        'js' => '<script src="%s" type="text/javascript"></script>',
        'css' => '<link href="%s" rel="stylesheet" type="text/css">'
    );

    /**
     * @param $files
     * @param $template
     */
    protected static function resource($files, $template)
    {

        $template = self::$templates[$template];

        if (is_array($files)) {
            foreach ($files as $file) {
                return sprintf($template, $file) . "\n";
            }
        } else {
                return sprintf($template, $files) . "\n";
        }
    }

    public static function js(Array $files)
    {
        if (is_array($files)) {
            foreach ($files as $key => $value) {
                echo static::resource($value, 'js');
            }
        } else {
            echo static::resource($files, 'js');

        }
    }


    public static function css(Array $files)
    {
        if (is_array($files)) {
            foreach ($files as $key => $value) {
                echo static::resource($value, 'css');
            }
        } else {
            echo static::resource($files, 'css');
        }
    }

}
