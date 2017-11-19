<?php

/**
 * APWEB Framework (http://framework.artphoweb.com/)
 * APWEB FW(tm) : Rapid Development Framework (http://framework.artphoweb.com/)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @link      http://github.com/zebedeu/artphoweb for the canonical source repository
 * @copyright (c) 2015.  APWEB  Software Technologies AO Inc. (http://www.artphoweb.com)
 * @license   http://framework.artphoweb.com/license/new-bsd New BSD License
 * @author    Marcio Zebedeu - artphoweb@artphoweb.com
 * @version   1.0.0
 */

namespace Ballybran\Database\Drives;

use PDO;

/**
 * ImageInterface AbstractDatabaseInterface
 * @package Ballybran\Database\Drives
 */
interface AbstractDatabaseInterface {

    /**
     *
     */
    const HOST ="localhost";
    /**
     *
     */
    const UNAME ="root";
    /**
     *
     */
    const PW ="root";
    /**
     *
     */
    const DBNAME = "";


    /**
     * @param $sql
     * @param array $array
     * @param int $fetchMode
     * @return mixed
     */
    public function selectManager($sql, $array = array(), $fetchMode = PDO::FETCH_ASSOC);


    /**
     * @param $table
     * @param null $fields
     * @param null $where
     * @param null $order
     * @param null $limit
     * @param null $offset
     * @param array $array
     * @param $fetchMode
     * @return mixed
     */
    public function find($table, $fields = null, $where = null, $order= null , $limit=null, $offset=null, $array = array(), $fetchMode );


    /**
     * @param $table
     * @param $data
     * @param null $where
     * @return mixed
     */
    public function save( $table, $data, $where= null);


    /**
     * @param $table
     * @param array $data
     * @return mixed
     */
    public function insert($table, array $data);

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
