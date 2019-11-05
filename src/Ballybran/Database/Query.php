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


namespace Ballybran\Database;


class Query
{

    private static $fields = "";
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