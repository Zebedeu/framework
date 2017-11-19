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

namespace Ballybran\Database;

use PDO;

class DBconnection extends PDOStatement {

    /**
     *
     * @params array
     * */
    private $params = array();

    /**
     *
     * @_instances array
     * */
    private $_instances = array();

    /**
     *
     * @var string
     * */
    private $beginTransactioncount = 0;

    function __construct($params) {
        $this->params = $params;
    }

     /**
      * @return mixed
      * @throws \Exception
      */
     public function connection() {

            try {
                $this->_instances = new PDO($this->params['dns'], $this->params['users'], $this->params['pass']);

                $attributes = array(
                    "AUTOCOMMIT", "ERRMODE", "CASE", "CLIENT_VERSION", "CONNECTION_STATUS",
                    "ORACLE_NULLS", "PERSISTENT", "SERVER_INFO", "SERVER_VERSION"
                );
                foreach ($attributes as $value) {
                    $this->_instances->getAttribute(constant("PDO::ATTR_$value")). "\n";
                }
            } catch (\PDOException $exc) {
                throw new \Exception('Failed to connect to database. Reason: ' . $exc->getMessage());
        }

        return $this->_instances;
    }

    /**
     *
     * @return bool
     * */
    protected function _beginTransaction() {
        if (!$this->beginTransactioncount && $this->beginTransactioncount++) {
            return parent::beginTransaction();
        }
        return $this->beginTransactioncount >= 0;
    }

    /**
     *
     * @return bool
     * */
    protected function _commit() {
        $beginTransactioncount =0;
        if (!++$beginTransactioncount) {
            return parent::commit();
        }
        return $this->beginTransactioncount >= 0;
    }

    /**
     *
     * @return bool
     * */
    protected function _Rollback() {
        if ($this->beginTransactioncount >= 0) {
            $this->beginTransactioncount = 0;
            return parent::rollBack();
        }
    }

}
