<?php
/**
 * Created by PhpStorm.
 * User: artphotografie
 * Date: 17/10/17
 * Time: 11:39
 */

use Ballybran\Helpers\Security\Val;
use PHPUnit\Framework\TestCase as PHPUnit;

class ValTest extends PHPUnit
{
    private $val;
    public function setUp()
    {
        $this->val = new Val();
    }

    public function testValMaxLength()
    {
        $max = $this->val->maxlength("Ola John Doe", 12);

        $this->assertEquals("", $max);

    }

    public function testValMinLength()
    {
        $max = $this->val->minlength("Ola John Doe", 12);

        $this->assertEquals("", $max);

    }
}
