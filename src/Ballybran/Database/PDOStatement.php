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

class PDOStatement extends \PDOStatement
{

    function __construct()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function setFetchMode(int $mode = PDO::FETCH_BOTH, mixed ...$args)
    {
        // This thin wrapper is necessary to shield against the weird signature
        // of PDOStatement::setFetchMode(): even if the second and third
        // parameters are optional, PHP will not let us remove it from this
        // declaration.
        try {
            if ($args === null ) {
                return parent::setFetchMode($mode);
            }

            return parent::setFetchMode($mode, $args);
        } catch (\PDOException $exception) {
            throw new PDOException($exception);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function bindValue($param, $value, $type = \PDO::PARAM_STR): bool
    {
        try {
            return parent::bindValue($param, $value, $type);
        } catch (\PDOException $exception) {
            throw new \PDOException($exception);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function bindParam($column, &$variable, $type = \PDO::PARAM_STR, $length = null, $driverOptions = null): bool
    {
        try {
            return parent::bindParam($column, $variable, $type, $length, $driverOptions);
        } catch (\PDOException $exception) {
            throw new \PDOException($exception);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function execute(?array $params = null): bool
    {
        try {
            return parent::execute($params);
        } catch (\PDOException $exception) {
            throw new \PDOException($exception);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function fetch($fetchMode = null, $cursorOrientation = null, $cursorOffset = null): bool
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
            throw new \PDOException($exception);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function fetchAll(int $mode = PDO::FETCH_BOTH, mixed ...$args): array {
    
        try {
            if ($mode === null && $args === null) {
                return parent::fetchAll();
            }

            if ($args === null) {
                return parent::fetchAll($mode);
            }

            return parent::fetchAll($mode, $args);
        } catch (\PDOException $exception) {
            throw new \PDOException($exception);
        }
    }

    /**
     * {@inheritdoc}
     */
        public function fetchColumn(int $column = 0): mixed { 
    
        try {
            return parent::fetchColumn($column);
        } catch (\PDOException $exception) {
            throw new \PDOException($exception);
        }
    
    }

}
