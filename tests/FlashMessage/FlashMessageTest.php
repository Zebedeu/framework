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

use \Ballybran\Helpers\Event\FlashMessage;
use PHPUnit\Framework\TestCase  as PHPUnit;
class FlashMessageTest extends PHPUnit
{

    private $flash;
    private $registry;

    protected function setUp()
    {
        $this->registry =  \Ballybran\Helpers\Event\Registry::getInstance();
    }

    public function testDisplayMessageWarnning() {

      $callback =   FlashMessage::display("Warning", "Please!! data invaid");

        $this->assertEquals("Please!! data invaid", $callback);

    }

    public function testDisplayMessageSucess() {

        $callback =   FlashMessage::display("sucess", "win!! data is valid");

        $this->assertEquals("win!! data is valid", $callback);

    }

    public function testRegistryMessage()
    {
       $veriry = $this->registry->set("sucess", str);

       $this->assertTrue($this->registry->isValid("sucess"));
    }

}