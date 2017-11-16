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

/**
 * Created by PhpStorm.
 * User: artphotografie
 * Date: 08/01/17
 * Time: 02:54
 */

namespace Ballybran\Database;


class Query
{

    private static $fields ="";
    private static $table;
    private static $where = "";
    private static $limit = 1;
    private static $offset;
    private static $order = "";


    /**
     * @return string
     */
    public static function getFields(): string
    {
        return self::$fields;
    }

    /**
     * @param string $fields
     */
    public static function setFields(string $fields)
    {
        self::$fields = $fields;
    }

    /**
     * @return string
     */
    public static function getTable(): string
    {
        return self::$table;
    }

    /**
     * @param string $table
     */
    public static function setTable(string $table)
    {
        self::$table = $table;
    }

    /**
     * @return string
     */
    public static function getWhere(): string
    {
        return self::$where;
    }

    /**
     * @param string $where
     */
    public static function setWhere(string $where)
    {
        self::$where = $where;
    }

    /**
     * @return int
     */
    public static function getLimit(): int
    {
        return self::$limit;
    }

    /**
     * @param int $limit
     */
    public static function setLimit(int $limit)
    {
        self::$limit = $limit;
    }

    /**
     * @return mixed
     */
    public static function getOffset()
    {
        return self::$offset;
    }

    /**
     * @param mixed $offset
     */
    public static function setOffset($offset)
    {
        self::$offset = $offset;
    }

    /**
     * @return string
     */
    public static function getOrder(): string
    {
        return self::$order;
    }

    /**
     * @param string $order
     */
    public static function setOrder(string $order)
    {
        self::$order = $order;
    }



     public function Table()
    {
        $sql = ' SELECT ' . ((self::getFields()) ?? "*") . ' FROM ' . ((self::getTable())) . ((self::getWhere()) ? ' WHERE ' . self::getWhere() : " ")
            . ((self::getLimit()) ? ' LIMIT ' . self::getLimit() : " ")
            . ((self::getOffset() && self::getLimit()) ? ' OFFSET ' . self::getOffset() : " ")
            . ((self::getOrder()) ? ' ORDER BY ' . self::getOrder() : " ");

        return $sql;
    }


}