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

namespace Ballybran\Config;

/**
 *
 * Also spl_autoload_register (Take a look at it if you like)
 *
 */
spl_autoload_register(function($class) {

    if (file_exists(str_replace('\\', DS, $class) . '.php')) {
        $file = str_replace('\\', DS, $class) . '.php';

        require_once $file;
    }

});



function __autoload($class)
{
    $libs = './';
    $ext = '.php';
    $file = search_lib($libs, $class . $ext);
    // Se encontrou inclui o arquivo
    if (false !== $file) {
        require_once $file;
    }
    // Se não encontrar o arquivo lança um erro na tela. :)
    else {
        $msg = "Autoload fatal erro: Can't find the file {$class}!";
        error_log($msg);
        exit('<br><br><strong>' . $msg . '</strong>');
    }
}
