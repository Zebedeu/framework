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

use PDO;

/**
 * ImageInterface AbstractDatabaseInterface
 * @package Ballybran\Database\Drives
 */
interface AbstractDatabaseInterface
{

    /**
     *
     */
    const HOST = "localhost";
    /**
     *
     */
    const UNAME = "root";
    /**
     *
     */
    const PW = "root";
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
    public function find(string $table, string $fields = null, string $where = null, string $order = null, int $limit = null, $offset = null, array $array = array(), $fetchMode = \PDO::FETCH_ASSOC);


    /**
     * @param $table
     * @param $data
     * @param null $where
     * @return mixed
     */
    public function save($table, $data, $where = null);


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


}
