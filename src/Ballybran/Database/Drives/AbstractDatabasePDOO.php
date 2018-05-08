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

namespace Ballybran\Database\Drives;
use Ballybran\Database\DBconnection;
use Ballybran\Helpers\vardump\Vardump;
use PDO;
use function var_dump;

class AbstractDatabasePDOO
{

    public $conn;
    public $stmt;
    /**
     * @var array
     */
    private $param;
    private $_instances;
    private $params;

    /**
     * DatabasePDOO constructor.
     * @param array $param
     */
    public function __construct($params)
    {
        $this->params = $params;

        try {


            $this->_instances = new PDO("mysql:host=localhost;port=8889;dbname=apweb", "root",  "root"  );

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

    public function select($select) {


      $stmt =  $this->_instances->prepare("SELECT * FROM $select");
      $stmt->execute();
      $stmt->fetchAll(\PDO::FETCH_ASSOC);


         return $this;

    }

    public function table($table) {
        echo "$table";
        return $this;
    }
    public function Backup($localation){

    }

}