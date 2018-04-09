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

use Ballybran\Core\Controller\AbstractControllerInterface;
use Ballybran\Helpers\Utility\Hash;
use PHPUnit\Framework\TestCase as PHPUnit;


class ControllerTest extends PHPUnit {

    private $objController;

    public function setUp() {
        $this->objController = new \Ballybran\Core\Controller\AbstractController();

    }

    public function testIfControllerIsInstanciOf(){


       $this->assertInstanceOf(AbstractControllerInterface::class, $this->objController);
    }

    public function testClassInstance()
    {

        $this->assertInstanceOf('\Ballybran\Core\Model\Model', $this->objController);

    }

    public function testCreateHashCript(){

        $string = "test1234";
        $hash = Hash::Create(ALGO, $string, HASH_KEY);

        $this->assertNotFalse($hash);

    }


}