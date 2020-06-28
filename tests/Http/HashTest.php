<?php
/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 05/04/18
 * Time: 09:02
 */

use PHPUnit\Framework\TestCase;

class HashTest extends TestCase
{


    public function testHash()
    {
        $hash = \Ballybran\Helpers\Utility\Hash::token(7777);
        $hash2 = \Ballybran\Helpers\Utility\Hash::token();
        $this->assertTrue(true , $hash);
        $this->assertThat(
        $hash,
        $this->logicalNot(
            $this->equalTo($hash2)
        )
    );

    }

    public function testIfhash_password()
    {
        $hash = \Ballybran\Helpers\Utility\Hash::hash_password("IT IS TEST");
        $this->assertTrue(true , $hash);

    }

    public function testIfHashverify_password()
    {

        $hash = \Ballybran\Helpers\Utility\Hash::hash_password("IT IS TEST");
        $verify = \Ballybran\Helpers\Utility\Hash::verify_password("IT IS TEST" , $hash);
        $this->assertEquals(true , $verify);
    }
}