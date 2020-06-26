<?php
/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 09/01/18
 * Time: 16:33
 */

namespace Ballybran\Database;

use PDO;

class Backup extends DBconnection
{

    private $tables = array();
    private $conn;

    public function __construct($params)
    {
        parent::__construct($params);

        $this->conn = $this->connection();
    }



//put table names you want backed up in this array.
//leave empty to do all


    function backup_tables($file, $compress = false, $tables = null)
    {

        $this->conn->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_TO_STRING);

//Script Variables
        $compression = $compress;
        $BACKUP_PATH = $file;


//create/open files
        if ($compression) {
            $zp = gzopen($BACKUP_PATH . '', "w9");
        } else {
            $handle = fopen($BACKUP_PATH, 'a+');
        }


//array of all database field types which just take numbers 
        $numtypes = array('tinyint', 'smallint', 'mediumint', 'int', 'bigint', 'float', 'double', 'decimal', 'real');

//get all of the tables
        if (empty($tables)) {
            $pstm1 = $this->conn->query('SHOW TABLES');
            while ($row = $pstm1->fetch(PDO::FETCH_NUM)) {
                $tables[] = $row[0];
            }
        } else {
            $tables = is_array($tables) ? $tables : explode(',', $tables);
        }

//cycle through the table(s)

        foreach ($tables as $table) {
            $result = $this->conn->query('SELECT * FROM ' . $table);
            $num_fields = $result->columnCount();
            $num_rows = $result->rowCount();

            $return = "";
//uncomment below if you want 'DROP TABLE IF EXISTS' displayed
//$return.= 'DROP TABLE IF EXISTS `'.$table.'`;'; 


//table structure
            $pstm2 = $this->conn->query('SHOW CREATE TABLE ' . $table);
            $row2 = $pstm2->fetch(PDO::FETCH_NUM);
            $ifnotexists = str_replace('CREATE TABLE', 'CREATE TABLE IF NOT EXISTS', $row2[1]);
            $return .= "\n\n" . $ifnotexists . ";\n\n";


            if ($compression) {
                gzwrite($zp, $return);
            } else {
                fwrite($handle, $return);
            }
            $return = "";

//insert values
            if ($num_rows) {
                $return = 'INSERT INTO `' . $table . "` (";
                $pstm3 = $this->conn->query('SHOW COLUMNS FROM ' . $table);
                $count = 0;
                $type = array();

                while ($rows = $pstm3->fetch(PDO::FETCH_NUM)) {

                    if (stripos($rows[1], '(')) {
                        $type[$table][] = stristr($rows[1], '(', true);
                    } else {
                        $type[$table][] = $rows[1];
                    }

                    $return .= $rows[0];
                    $count++;
                    if ($count < ($pstm3->rowCount())) {
                        $return .= ", ";
                    }
                }

                $return .= ")" . ' VALUES';

                if ($compression) {
                    gzwrite($zp, $return);
                } else {
                    fwrite($handle, $return);
                }
                $return = "";
            }

            while ($row = $result->fetch(PDO::FETCH_NUM)) {
                $return = "\n\t(";
                for ($j = 0; $j < $num_fields; $j++) {
                    $row[$j] = addslashes($row[$j]);
//$row[$j] = preg_replace("\n","\\n",$row[$j]);


                    if (isset($row[$j])) {
//if number, take away "". else leave as string
                        if (in_array($type[$table][$j], $numtypes)) {
                            $return .= $row[$j];
                        } else {
                            $return .= '"' . $row[$j] . '"';
                        }
                    } else {
                        $return .= '""';
                    }
                    if ($j < ($num_fields - 1)) {
                        $return .= ',';
                    }
                }
                $count++;
                if ($count < ($result->rowCount())) {
                    $return .= "),";
                } else {
                    $return .= ");";

                }
                if ($compression) {
                    gzwrite($zp, $return);
                } else {
                    fwrite($handle, $return);
                }
                $return = "";
            }
            $return = "\n\n-- ------------------------------------------------ \n\n";
            if ($compression) {
                gzwrite($zp, $return);
            } else {
                fwrite($handle, $return);
            }
            $return = "";
        }


        $error1 = $pstm2->errorInfo();
        $error2 = $pstm3->errorInfo();
        $error3 = $result->errorInfo();
        echo $error1[2];
        echo $error2[2];
        echo $error3[2];

        if ($compression) {
            gzclose($zp);
        } else {
            fclose($handle);
        }
    }
}