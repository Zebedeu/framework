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

use PHPUnit\Framework\TestCase;

use Ballybran\Helpers\Event\Registry;

class RegistryTest extends TestCase
{
    private $reg;

    public function setUp()
    {
        $this->reg = Registry::getInstance();

    }

    public function testUniqueness()
    {
        $firstCall = Registry::getInstance();
        $secondCall = Registry::getInstance();
        $this->assertInstanceOf(Registry::class , $firstCall);
        $this->assertSame($firstCall , $secondCall);
    }
    function testRegistryIsSingleton()
    {
        $this->assertInstanceOf('Ballybran\Helpers\Event\Registry' , $this->reg);
    }

    function testEmptyRegistryIsInvalid()
    {
        $this->assertFalse($this->reg->isValid('key'));
    }

    public function testEmptyRegistryKeyReturnsNull()
    {
        $this->assertNull($this->reg->get('key'));
    }

    public function testRegistyKeyBecomesValid()
    {
        $test_value = "something";
        $this->reg->set("key" , $test_value);

        $this->assertTrue($this->reg->isValid("key"));

    }

    public function testRegistyKeyAndValueIfEqualReturn()
    {

        $this->assertEquals("something" , $this->reg->get("key"));
    }

    public function testRegistyKeyAndValueIn_call_IfEqualReturn()
    {

        $this->reg->key = "somethings using __call magic method";
        $this->assertEquals("somethings using __call magic method" , $this->reg->key);
    }

}