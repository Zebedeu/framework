<?php
/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 05/04/18
 * Time: 09:02
 */

use PHPUnit\Framework\TestCase;

class HashTest extends TestCase{


    public function setUp()
    {

    }
    public function testHash()
    {
        $hash = \Ballybran\Helpers\Utility\Hash::token();
        $this->assertTrue(true, $hash);
    }

    public function testIfhash_password()
    {
        $hash = \Ballybran\Helpers\Utility\Hash::hash_password("IT IS TEST");
        $this->assertTrue(true, $hash);

    }

    public function testIfHashverify_password() {

        $hash = \Ballybran\Helpers\Utility\Hash::hash_password("IT IS TEST");
        $verify = \Ballybran\Helpers\Utility\Hash::verify_password("IT IS TEST", $hash);

        $this->assertEquals(1, $verify);

    }
}