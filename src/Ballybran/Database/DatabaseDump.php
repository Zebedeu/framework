<?php
/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 08/01/18
 * Time: 21:14
 */

namespace Ballybran\Database;

use PDO;

class DatabaseDump extends DBconnection
{


    private $db;
    private $host, $user, $pass, $dbname;
    private $sql, $removeAI;
    /**
     * @var array
     */
    private $params;

    public function __construct(array $params)
    {

        parent::__construct($params);
        $this->params = $params;
        $this->conn = $this->connection();
    }

    private function ln($text = '')
    {
        $this->sql = $this->sql . $text . "\n";
    }

    public function dump($file)
    {
        $this->ln("SET FOREIGN_KEY_CHECKS=0;\n");

        $tables = $this->conn->query('SHOW TABLES')->fetchAll(PDO::FETCH_BOTH);


        foreach ($tables as $table) {

            for ($i = 0; $i < $select; $i++) {
                while ($select) {
                    $select .= 'INSERT INTO ' . $table . ' VALUES(';
                    for ($j = 0; $j < $select; $j++) {
                        $row[$j] = addslashes($select[$j]);
                        if (isset($row[$j])) {
                            $select .= '"' . $row[$j] . '"';
                        } else {
                            $select .= '""';
                        }
                        if ($j < ($select - 1)) {
                            $select .= ',';
                        }
                    }
                    $select .= ");\n";
                }
            }
            $table = $table[0];
            $this->ln('DROP TABLE IF EXISTS `' . $table . '`;');

            $schemas = $this->conn->query("SHOW CREATE TABLE `{$table}`")->fetchAll(PDO::FETCH_ASSOC);

            foreach ($schemas as $schema) {
                $schema = $schema['Create Table'];
                if ($this->removeAI) $schema = preg_replace('/AUTO_INCREMENT=([0-9]+)(\s{0,1})/', '', $schema);
                $this->ln($schema . ";\n\n");
            }
        }


        file_put_contents($file, $this->sql);
    }
}

