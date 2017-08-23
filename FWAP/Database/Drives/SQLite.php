<?php

/**
 *
 * APWEB Framework (http://framework.artphoweb.com/)
 * APWEB FW(tm) : Rapid Development Framework (http://framework.artphoweb.com/)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @link      http://github.com/zebedeu/artphoweb for the canonical source repository
 * @copyright (c) 2016.  APWEB  Software Technologies AO Inc. (http://www.artphoweb.com)
 * @license   http://framework.artphoweb.com/license/new-bsd New BSD License
 * @author    Marcio Zebedeu - artphoweb@artphoweb.com
 * @version   1.0.0
 */
class SQLite3 implements interfaceDatabase {

    public $linha;

    public function __construct($DB_TYPE, $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS) {
        parent::__construct($DB_TYPE . ':host=' . $DB_HOST . ';dbname=' . $DB_NAME, $DB_USER, $DB_PASS);
    }


    /**
     * @param $table
     * @param $array
     */
    public function CreatedDatabase($table, $array) {

//        $db->exec('CREATE TABLE $table (bar $data)');
    }

    public function select($sql, $array = array(), $fetchMode = PDO::FETCH_ASSOC) {
        $stmt = $this->prepare($sql);

        foreach ($array as $key => $values) {
            $stmt->bindValue("$key", $values);
        }
        $stmt->execute();
        return $stmt->fetchAll($fetchMode);
    }

    /**
     * @param $table da base de dados
     * @param $data recebido do array
     * @return bool
     */
    public function insert($table, $data) {
        krsort($data);

        $fieldNme = implode('`,`', array_keys($data));
        $fieldValues = ':' . implode(',:', array_keys($data));

        $stmt = $this->prepare("INSERT INTO $table (`$fieldNme`) VALUES ($fieldValues)");

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
    public function update($table, $data, $where) {
        ksort($data);

        $fielDetail = null;

        foreach ($data as $key => $values) {
            $fielDetail .= "`$key`=:$key,";
        }

        $fielDetail = trim($fielDetail, ',');
        $stmt = $this->prepare("UPDATE $table SET $fielDetail WHERE $where ");
        foreach ($data as $key => $values) {
            $stmt->bindValue(":$key", $values);
        }

        return $stmt->execute();
    }

    /**
     * @param $table
     * @param $where
     * @param int $limit
     * @return int
     */
    public function delete($table, $where, $limit = 1) {
        return $this->exec("DELETE FROM $table WHERE $where LIMIT $limit");
    }

}
