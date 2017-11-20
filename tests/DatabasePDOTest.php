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
