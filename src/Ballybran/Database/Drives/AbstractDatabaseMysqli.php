<?php

/**
 * KNUT7 K7F (https://marciozebedeu.com/)
 * KNUT7 K7F (tm) : Rapid Development Framework (https://marciozebedeu.com/)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @link      https://github.com/knut7/framework/ for the canonical source repository
 * @copyright (c) 2015.  KNUT7  Software Technologies AO Inc. (https://marciozebedeu.com/)
 * @license   https://marciozebedeu.com/license/new-bsd New BSD License
 * @author    Marcio Zebedeu - artphoweb@artphoweb.com
 * @version   1.0.2
 */

namespace Ballybran\Database\Drives;

use mysqli;

class AbstractDatabaseMysqli extends mysqli implements AbstractDatabaseInterface
{

    private $mysqli;
    private $limit;
    private $table = array();
    private $result;

    public function __construct()
    {
        $this->mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
        $this->conexao();
    }

    public function conexao()
    {

        if ($this->mysqli->connect_errno) {
            throw new \Exception("Error: " . mysqli_error($this->mysqli) . '<br/>
            Error No: ' . mysqli_errno($this->mysqli) . '<br/> 
            Error in: <b>' . $trace[1]['file'] . '</b> line <b>' . $trace[1]['line'] . '</b><br/>' . $sql);
        }
    }

    public function selectManager($sql, $array = array(), $fetchMode = MYSQLI_ASSOC)
    {

        if ($result = mysqli_query($this->mysqli, $sql)) {
            while ($row = mysqli_fetch_array($result)) {
                return $row;
            }
            mysqli_free_result($result);

        }
//
    }

    public function insert($table, array $data)
    {

        $fieldName = implode(',', array_keys($data));
        foreach (array_values($data) as $value) {

            isset($fieldva) ? $fieldva .= ',' : $fieldva = '';
            $fieldva .= '\'' . $this->mysqli->real_escape_string($value) . '\'';
        }
        $this->mysqli->real_query('INSERT INTO ' . $table . ' (' . $fieldName . ') VALUES (' . $fieldva . ')');
        $this->mysqli->close();
    }

    public function update($table, $data, $where)
    {
        $fieldetail = Null;

        foreach ($data as $key => $value) {
            $fieldetail .= "`$key`=:$key,";
        }

        $fieldetail = trim($fieldetail, ',');
        $this->mysqli->real_query("UPDATE $table SET $fieldetail WHERE $where");

        $this->mysqli->close();
    }

    /**
     * select
     * @param string $sql An SQL string
     * @param array $array Paramters to bind
     * @param constant $fetchMode A PDO Fetch mode
     * @return mixed
     */
    public function select($table, $fields = "*", $where = ' ', $order = '', $limit = null, $offset = null, $array = array(), $fetchMode = MYSQLI_ASSOC )
    {
        // TODO: Implement select() method.
    }

    public function delete($table, $where, $limit = 1)
    {
        // TODO: Implement delete() method.
    }

    public function get_Data_definition($db)
    {
        // TODO: Implement get_Data_definitin() method.
    }

    public function createTable(String $table, array $fileds)
    {
        // TODO: Implement createTable() method.
    }

    /**
     * select
     * @param string $sql An SQL string
     * @param array $array Paramters to bind
     * @param constant $fetchMode A PDO Fetch mode
     * @return mixed
     */
    public function find($table, $fields = null, $where = null, $order = null, $limit = null, $offset = null, $array = array(), $fetchMode = \PDO::FETCH_ASSOC)
    {
        // TODO: Implement find() method.
    }


    /**
     * @param $table
     * @param $data
     * @param bool $isId
     * @param null $where
     * @return mixed
     */
    public function save($table, $data, $isId = false, $where = null)
    {
        // TODO: Implement save() method.
    }

    public function Backup($localation)
    {

    }

    public function colum($table, $column, $varchar, $null)
    {
        // TODO: Implement colum() method.
    }
}