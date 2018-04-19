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

namespace Ballybran\Database\Drives;

use mysqli;
use PDO;

class AbstractDatabaseMysqli implements AbstractDatabaseInterface
{

    private $mysqli;
    private $limit;
    private $table = array ();
    private $result;

    public function __construct()
    {
        $this->mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
    }


     public function selectManager($sql, $array = array(), $fetchMode = PDO::FETCH_ASSOC)
     {
         // TODO: Implement selectManager() method.
     }

     public function find($table, $fields = null, $where = null, $order = null, $limit = null, $offset = null, $array = array(), $fetchMode)
     {
         // TODO: Implement find() method.
     }

     public function save($table, $data, $where = null)
     {
         // TODO: Implement save() method.
     }

     public function insert($table, array $data)
     {
         // TODO: Implement insert() method.
     }

     public function update($table, $data, $where)
     {
         // TODO: Implement update() method.
     }

     public function delete($table, $where, $limit)
     {
         // TODO: Implement delete() method.
     }
 }