<?php
/**
 * Created by PhpStorm.
 * User: artphotografie
 * Date: 17/10/17
 * Time: 11:08
 */

use Ballybran\Database\Drives\AbstractDatabaseInterface;
use Ballybran\Database\Drives\AbstractDatabasePDO;
use PHPUnit\Framework\TestCase;

class DatabasePDOTest extends TestCase
{


    public function testInsertData() {
        $D = [1,2,3,4];

    $this->assertEquals([1,2,3,4], $D);

    }

}
