<?php


use Ballybran\Core\Controller\Controller;
use Ballybran\Core\Controller\iController;
use Ballybran\Helpers\Utility\Hash;
use PHPUnit\Framework\TestCase as PHPUnit;


class ControllerTest extends PHPUnit {

    private $objController;

    public function setUp() {
        $this->objController = new \Ballybran\Core\Controller\Controller();

    }

    public function testIfControllerIsInstanciOf(){


       $this->assertInstanceOf(iController::class, $this->objController);
    }

    public function testClassInstance()
    {

        $this->assertInstanceOf('\Ballybran\Core\Model\Model', $this->objController);

    }

    public function testReturnToHashTokenClass() {

        $token = Hash::token( 233);

        $this->assertNotFalse($token);
    }

    public function testCreateHashCript(){

        $string = "test1234";
        $hash = Hash::Create(ALGO, $string, HASH_KEY);

        $this->assertNotFalse($hash);

    }


}