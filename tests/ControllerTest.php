<?php
/**
 * APWEB Framework (http://framework.artphoweb.com/)
 * APWEB FW(tm) : Rapid Development Framework (http://framework.artphoweb.com/)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @link      http://github.com/zebedeu/artphoweb for the canonical source repository
 * @copyright (c) 2015.  APWEB  Software Technologies AO Inc. (http://www.artphoweb.com)
 * @license   http://framework.artphoweb.com/license/new-bsd New BSD License
 * @author    Marcio Zebedeu - artphoweb@artphoweb.com
 * @version   1.0.0
 */

use Ballybran\Helpers\Utility\Hash;
use PHPUnit\Framework\TestCase as PHPUnit;


class ControllerTest extends PHPUnit {

    public function testCase(){

       $obj = new \Ballybran\Core\Controller\AbstractController();

       $this->getActualOutput();
    }

    public function testReturnToHashTokenClass() {

        $token = Hash::token( 12);

        $this->returnValue($token);
    }
}