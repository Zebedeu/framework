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


use PHPUnit\Framework\TestCase as PHPUnit;
use \Ballybran\Database\RegistryDatabase;

class RegistryDatabaseTest extends PHPUnit
{


    private $registry;


    public function setUp()
    {
        $this->registry = RegistryDatabase::getInstance();

    }

    public function testRegistryIsSingleton() {

        $this->assertInstanceOf('\Ballybran\Database\RegistryDatabase', $this->registry );
        $this->returnSelf();

    }

    public function testIfGetInstanceReturnInstance()
    {
        $this->assertInstanceOf('\Ballybran\Database\RegistryDatabase', $this->registry );

        $this->returnCallback($this->registry->getInstance());
    }

    public function testIRegistryClassValid() {

        $this->registry->set("PDO", str );
        $this->assertTrue($this->registry->isRegistered("PDO"));

    }

    public function testIunRegistryClassValid() {

        $this->registry->set("PDO", str);

        $this->assertNull($this->registry->unRegistered("PDO"));
    }


}