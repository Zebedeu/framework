<?php


use PHPUnit\Framework\TestCase as PHPUnit;


class ControllerTest extends PHPUnit {

    public function testCase(){

       $obj = new \FWAP\Core\Controller\Controller();

       $this->getActualOutput();
    }
}