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
/**
 * Created by PhpStorm.
 * User: artphotografie
 * Date: 2016/02/14
 * Time: 1:16 PM
 */

namespace FWAP\Database\Drives;

use PDO;

interface iDatabase {

    /**
     * @param $sql
     * @param array $array
     * @param int $fetchMode
     * @return mixed
     */
    public function selectManager($sql, $array = array(), $fetchMode = PDO::FETCH_ASSOC);

    /**
     * select
     * @param string $sql An SQL string
     * @param array $array Paramters to bind
     * @param constant $fetchMode A PDO Fetch mode
     * @return mixed
     */
    public function select($table, $fields ="*", $where = ' ', $order='', $limit=null, $offset=null,  $array = array(), $fetchMode);

    /**
     * @param $table da base de dados
     * @param $data recebido do array
     * @return bool
     */
    public function insert($table, $data);

    /**
     * @param $table
     * @param $data
     * @param $where
     * @return bool
     */
    public function update($table, $data, $where);

    /**
     * @param $table
     * @param $where
     * @param $limit
     * @return mixed
     */
    public function delete($table, $where, $limit);

    /**
     * @param $db
     * @return mixed
     */
    public function get_Data_definition($db);

    /**
     * @param String $table
     * @param array $fileds
     * @return mixed
     */
    public function createTable(String $table, array $fileds);



}
