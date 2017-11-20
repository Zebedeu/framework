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



namespace Ballybran\Config;


use Ballybran\Core\Caller\Caller;
use Module\Apps\Module;

class LoadModelsEvent extends Caller
{

    public function init()
    {
        $module = new Module();
        $d = $module->Config();

        foreach ($d as $con => $item) {

            echo "Route " . $item . "<br><br>";

            foreach ($item as $ite => $vaItem) {
//
                echo "key 1 $vaItem" . "<br>";
            }
        }
    }

}