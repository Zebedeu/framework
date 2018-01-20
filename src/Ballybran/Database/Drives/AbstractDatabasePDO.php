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

use Ballybran\Database\Backup;
use Ballybran\Database\DatabaseDump;
use Ballybran\Database\DBconnection;
use Ballybran\Database\MySQLDump;
use Ballybran\Helpers\vardump\BaseVarDumper;
use PHPUnit\Runner\Exception;

/**
 * Class AbstractDatabasePDO
 * @package Ballybran\Database\Drives
 */
 class AbstractDatabasePDO extends DBconnection implements AbstractDatabaseInterface
{

    /**
     * @var mixed
     */
    private $conn;
     /**
      * @var array
      */
     private $param = [];

     /**
     * AbstractDatabasePDO constructor.
     * @param array $param
     */


    public function __construct( array $param = array () )
    {
        parent::__construct($param);

        $this->conn = $this->connection();
        $this->param = $param;
    }

     /**
      * select
      * @param string $sql An SQL string
      * @param array $array Paramters to bind
      * @param int $fetchMode
      * @return mixed
      */


    public function selectManager( $sql, $array = array (), $fetchMode = \PDO::FETCH_ASSOC )
    {

        $stmt = $this->conn->prepare($sql);

        foreach ($array as $key => $values) {
                $stmt->bindValue("$key", $values);
        }        $stmt->execute();

        do {
            return $stmt->fetchAll($fetchMode);
        } while (
            $stmt->nextRowset());

    }

    /**
     * @param $table
     * @param null $fields
     * @param null $where
     * @param null $order
     * @param null $limit
     * @param null $offset
     * @param array $array
     * @param int $fetchMode
     * @return mixed
     */
    public function find( $table, $fields = null, $where = null, $order = null, $limit = null, $offset = null, $array = array (), $fetchMode = \PDO::FETCH_ASSOC )
    {
        $sql = ' SELECT ' . (($fields) ?? "*") . ' FROM ' . (($table)) . (($where) ? ' WHERE ' . $where : " ")
            . (($limit) ? ' LIMIT ' . $limit : " ")
            . (($offset && $limit) ? ' OFFSET ' . $offset : " ")
            . (($order) ? ' ORDER BY ' . $order : " ");

        $stmt = $this->conn->prepare($sql);

        foreach ($array as $key => $values) {
            return  $stmt->bindValue("$key", $values);
        }
        $stmt->execute();


        do {
            return $stmt->fetchAll($fetchMode);
        } while (
            $stmt->nextRowset());

    }


    /**
     * @param $table da base de dados
     * @param $data recebido do array
     * @return bool
     */
    public function insert( $table, array $data )
    {

        try {
            krsort($data);

            $fieldNme = implode('`,`', array_keys($data));
            $fieldValues = ':' . implode(',:', array_keys($data));
            $this->_beginTransaction();

            $stmt = $this->conn->prepare("INSERT INTO $table (`$fieldNme`) VALUES ($fieldValues)");

            foreach ($data as $key => $values) {
                $stmt->bindValue(":$key", $values);
            }
            $this->_commit();
            return $stmt->execute();
            unset($stmt);
        } catch (Exception $e) {
            $this->_Rollback();
            echo "error insert " . $e->getMessage();
        }

    }

    /**
     * @param $table
     * @param $data
     * @param $where
     * @return bool
     */
    public function update( $table, $data, $where )
    {
        ksort($data);


        $fielDetail = null;

        foreach ($data as $key => $values) {
            $fielDetail .= "`$key`=:$key,";
        }

        $fielDetail = trim($fielDetail, ',');
        $stmt = $this->conn->prepare("UPDATE $table SET $fielDetail WHERE $where ");
        foreach ($data as $key => $values) {
            $stmt->bindValue(":$key", $values);
        }

        return $stmt->execute();

    }

    /**
     * @param $table
     * @param $data
     * @param $where
     * @return bool
     */
    public function save( $table, $data, $where = null )
    {
        ksort($data);

        if (isset($data['id'])) {

            ksort($data);


            $fielDetail = null;

            foreach ($data as $key => $values) {
                $fielDetail .= "`$key`=:$key,";
            }

            $fielDetail = trim($fielDetail, ',');
            $stmt = $this->conn->prepare("UPDATE $table SET $fielDetail WHERE $where ");
            foreach ($data as $key => $values) {
                $stmt->bindValue(":$key", $values);
            }

            return $stmt->execute();
        }
        $this->insert($table, $data);


    }

    /**
     * @param $table
     * @param $where
     * @param int $limit
     * @return int
     */
    public function delete( $table, $where, $limit = 1 )
    {
        return $this->conn->exec("DELETE FROM $table WHERE $where LIMIT $limit");
    }

    /**
     * @param $db
     * @return array
     */
    public function get_Data_definition( $db )
    {

        $stmt = $this->conn->prepare("SHOW COLUMNS FROM $db");

        if ($stmt->execute()) {
            while ($row = $stmt->fetch()) {
                return $this->columns[$row['Field']] = array ('allow_null' => $row['Null'],
                    'decimal' => NULL,
                    'default' => $row['Default'],
                    'extra' => $row['Extra'],
                    'key' => $row['Key'],
                    'length' => NULL,
                    'name' => $row['Field'],
                    'text' => NULL,
                    'type' => $row['Type']);
            }
        }
        ksort($this->columns);
    }

    /**
     * @param String $table
     * @param array $fileds
     */
    public function createTable( String $table, array $fileds )
    {
        ksort($fileds);

        $fieldNme = implode('`,', array_keys($fileds));
        $fieldValues = implode(', ', array_values($fileds[$fieldNme]));
        echo $fieldNme . ' ' . $fieldValues;

        $sql = "CREATE TABLE IF NOT EXISTS  clinica.$table ($fieldNme  $fieldValues)";
        var_dump($sql);

        $c = $this->conn->exec($sql);
        var_dump($c);

    }


}