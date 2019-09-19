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

namespace Ballybran\Database;

class PDOStatement extends \PDOStatement
{

    function __construct()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function setFetchMode($fetchMode, $arg2 = null, $arg3 = null)
    {
        // This thin wrapper is necessary to shield against the weird signature
        // of PDOStatement::setFetchMode(): even if the second and third
        // parameters are optional, PHP will not let us remove it from this
        // declaration.
        try {
            if ($arg2 === null && $arg3 === null) {
                return parent::setFetchMode($fetchMode);
            }

            if ($arg3 === null) {
                return parent::setFetchMode($fetchMode, $arg2);
            }

            return parent::setFetchMode($fetchMode, $arg2, $arg3);
        } catch (\PDOException $exception) {
            throw new PDOException($exception);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function bindValue($param, $value, $type = \PDO::PARAM_STR)
    {
        try {
            return parent::bindValue($param, $value, $type);
        } catch (\PDOException $exception) {
            throw new PDOException($exception);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function bindParam($column, &$variable, $type = \PDO::PARAM_STR, $length = null, $driverOptions = null)
    {
        try {
            return parent::bindParam($column, $variable, $type, $length, $driverOptions);
        } catch (\PDOException $exception) {
            throw new PDOException($exception);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function execute($params = null)
    {
        try {
            return parent::execute($params);
        } catch (\PDOException $exception) {
            throw new PDOException($exception);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function fetch($fetchMode = null, $cursorOrientation = null, $cursorOffset = null)
    {
        try {
            if ($fetchMode === null && $cursorOrientation === null && $cursorOffset === null) {
                return parent::fetch();
            }

            if ($cursorOrientation === null && $cursorOffset === null) {
                return parent::fetch($fetchMode);
            }

            if ($cursorOffset === null) {
                return parent::fetch($fetchMode, $cursorOrientation);
            }

            return parent::fetch($fetchMode, $cursorOrientation, $cursorOffset);
        } catch (\PDOException $exception) {
            throw new PDOException($exception);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function fetchAll($fetchMode = null, $fetchArgument = null, $ctorArgs = null)
    {
        try {
            if ($fetchMode === null && $fetchArgument === null && $ctorArgs === null) {
                return parent::fetchAll();
            }

            if ($fetchArgument === null && $ctorArgs === null) {
                return parent::fetchAll($fetchMode);
            }

            if ($ctorArgs === null) {
                return parent::fetchAll($fetchMode, $fetchArgument);
            }

            return parent::fetchAll($fetchMode, $fetchArgument, $ctorArgs);
        } catch (\PDOException $exception) {
            throw new PDOException($exception);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function fetchColumn($columnIndex = 0)
    {
        try {
            return parent::fetchColumn($columnIndex);
        } catch (\PDOException $exception) {
            throw new PDOException($exception);
        }
    }

}
