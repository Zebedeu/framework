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

use PHPUnit\Framework\TestCase;

use Ballybran\Helpers\Event\Registry;
class RegistryTest extends TestCase {


    protected function setUp() : void
    {

    }
    function testRegistryIsSingleton() {
        $this->assertInstanceOf ('Ballybran\Helpers\Event\Registry',  Registry::getInstance());
    }

	function testEmptyRegistryIsInvalid()
	{
		$reg = Registry::getInstance();
		$this->assertFalse($reg->isValid('key'));
	}

    public function testEmptyRegistryKeyReturnsNull(  )
    {
        $re = Registry::getInstance();
        $this->assertNull($re->get('key'));
	}

    public function testRegistyKeyBecomesValid(  )
    {
        $re = Registry::getInstance();
        $test_value = "something";

        $re->set("key", $test_value);

        $this->assertTrue($re->isValid("key"));

    }
}