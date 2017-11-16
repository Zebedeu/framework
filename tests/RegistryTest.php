<?php

use PHPUnit\Framework\TestCase;

use Ballybran\Helpers\Event\Registry;
class RegistryTest extends TestCase {


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