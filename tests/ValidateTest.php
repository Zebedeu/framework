<?php
/**
 * Created by PhpStorm.
 * User: artphotografie
 * Date: 17/10/17
 * Time: 11:54
 */

use Ballybran\Helpers\Security\Val;
use Ballybran\Helpers\Security\Validate;
use PHPUnit\Framework\TestCase as PHPUnit;


class ValidateTest extends PHPUnit
{
    private $valid;
    private $val;

    public function setUp()
    {
        $this->val = new Val();
        $this->valid = new Validate();
    }

    public function testValidIMethod()
    {
        $this->valid->setMethod("POST");
        $this->assertEquals("POST", $this->valid->getMethod());
    }

    public function testValidInputPost()
    {
        $_POST["nome"] = "John Doe";
        $this->valid->setMethod("POST");
        echo $this->valid->getMethod();
        $this->valid->post('nome')->val("maxlength", 10)->submit();
        $this->assertEquals(["nome" => "John Doe"], $this->valid->getPostData());


//        $this->assertEquals([], $this->valid->getPostData());

    }

    public function testValidInputGet()
    {
        $_GET["nome"] = "John Doe";

        if (!empty($_GET['nome'])) {
            $this->valid->setMethod("GET");
            echo $this->valid->getMethod();
            $this->valid->post('nome')->val("maxlength", 8)->submit();
            $this->assertEquals(["nome" => "John Doe"], $this->valid->getPostData());
        }

    }

    public function testIfValIsInstanceOfValidate()
    {

        $this->assertInstanceOf(Ballybran\Helpers\Security\Val::class, $this->val);

    }
}
