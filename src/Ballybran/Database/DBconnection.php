<?php

/**
 * KNUT7 K7F (https://marciozebedeu.com/)
 * KNUT7 K7F (tm) : Rapid Development Framework (https://marciozebedeu.com/).
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @see      https://github.com/knut7/framework/ for the canonical source repository
 *
 * @copyright (c) 2015.  KNUT7  Software Technologies AO Inc. (https://marciozebedeu.com/)
 * @license   https://marciozebedeu.com/license/new-bsd New BSD License
 * @author    Marcio Zebedeu - artphoweb@artphoweb.com
 *
 * @version   1.0.15
 */

namespace Ballybran\Database;

use PDO;

class DBconnection extends PDOStatement implements DBconnectionInterface
{
    /**
     * @params array
     * */
    private $params = array();

    /**
     * @_instances array
     * */
    private $_instances = array();

    /**
     * @var string
     * */
    private $beginTransactioncount = 0;

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function connection()
    {
        try {
            $this->_instances = new PDO($this->params['dns'], $this->params['users'], $this->params['pass'],
                [\PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8']);

            $attributes = array(
                'AUTOCOMMIT', 'ERRMODE', 'CASE', 'CLIENT_VERSION', 'CONNECTION_STATUS',
                'ORACLE_NULLS', 'PERSISTENT', 'SERVER_INFO', 'SERVER_VERSION',
            );
            foreach ($attributes as $value) {
                $this->_instances->getAttribute(constant("PDO::ATTR_$value")) . "\n";
            }
        } catch (\PDOException $exc) {

            if (_ERROR_ == "dev") {
                throw new \Exception('Failed to connect to database. Reason: ' . $exc->getMessage());

            } else {
                echo "<h1>Error establishing a database connection</h1>";
                exit;
            }
        }

        return $this->_instances;
    }

    /**
     * @return bool
     * */
    protected function _beginTransaction()
    {
        if (!$this->beginTransactioncount++) {
            return  $this->_instances->beginTransaction();
        }
        $this->exec('SAVEPOINT trans'.$this->transactionCounter);
        return $this->beginTransactioncount >= 0;
    }

    /**
     * @return bool
     * */
    protected function _commit()
    {
       if (! --$this->beginTransactioncount) {
            return $this->_instances->commit();
        }
        return $this->beginTransactioncount >= 0;
    }

    /**
     * @return bool
     * */
    protected function _Rollback()
    {
        if ( --$this->beginTransactioncount) {
            $this->_instances->exec('ROLLBACK TO trans '.$this->beginTransactioncount + 1);
            return true;
        }
            return $this->_instances->rollBack();
    }

    public function __destruct()
    {
        $this->_instances = null;
    }

    /**
     * Return last inserted id.
     *
     * @param string|null $sequence
     *
     * @return string
     */
    public function lastInsertId($sequence = null)
    {
        return $this->_instances->lastInsertId($sequence);
    }
}
