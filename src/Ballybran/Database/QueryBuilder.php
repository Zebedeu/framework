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
use Ballybran\Database\DBconnection;
use Ballybran\Database\Drives\QueryBuilderInterface;

/**
 * Class QueryBuilder
 * @method QueryBuilder table (string $table)
 * @method QueryBuilder join (string $join)
 * @method QueryBuilder fields (array $fields)
 * @method QueryBuilder where (array $where)
 * @method QueryBuilder order (array $order)
 * @method QueryBuilder group (array $group)
 * @method QueryBuilder having (array $having)
 * @method QueryBuilder limit (array $join)
 */
class QueryBuilder extends DBconnection
{
    /**
     * @var array
     */
    private $clausules = [];

    /**
     * @param $name
     * @param $arguments
     * @return $this
     */
    function __call($name , $arguments)
    {
        $clausule = $arguments[0];
        if (count( $arguments ) > 1) {
            $clausule = $arguments;
        }
        $this->clausules[strtolower( $name )] = $clausule;

        return $this;
    }

    /**
     * QueryBuilder constructor.
     * @param array $options
     */
    public function __construct(array $options)
    {
        parent::__construct( $options );
        $this->conn = $this->connection();

    }

    /**
     * @param array $values
     * @return string
     */
    public function insert(array $values = [] )
    {
        // recupera o nome da tabela
        // ou deixa uma marcação para mostrar que faltou informar esse campo
        $table = isset( $this->clausules['table'] ) ? $this->clausules['table'] : '<table>';

        // recupera o array dos campos
        // ou deixa uma marcação para mostrar que faltou informar esse campo
        $_fields = isset( $this->clausules['fields'] ) ? $this->clausules['fields'] : '<fields>';
//        $fields = implode( ', ' , $_fields );
//
//        // cria uma lista de rótulos para usar "prepared statement"
//        $_placeholders = array_map( function () {
//            return '?';
//        } , $_fields );
//        $placeholders = implode( ', ' , $_placeholders );

        krsort($_fields);
//
        $fieldName = implode('`,`', array_keys($_fields));
        $fieldValues = ':' . implode(',:', array_keys($_fields));
        $this->_beginTransaction();

        $command = [];
        $command[] = 'INSERT INTO';
        $command[] = $table;
        $command[] = '(' . $fieldName . ')';
        $command[] = 'VALUES';
        $command[] = '(' . $fieldValues . ')';

        // INSERT INTO {table} ({fields}) VALUES ({values});
        // junta o comando
        $sql = implode( ' ' , $command );

        return $this->executeInsert( $sql , $values );
    }

    /**
     * @param $values
     * @return string
     */
    public function select($values = [])
    {
        // recupera o nome da tabela
        // ou deixa uma marcação para mostrar que faltou informar esse campo
        $table = isset( $this->clausules['table'] ) ? $this->clausules['table'] : '<table>';

        // recupera o array dos campos
        // ou deixa uma marcação para mostrar que faltou informar esse campo
        $_fields = isset( $this->clausules['fields'] ) ? $this->clausules['fields'] : '*';
        $fields = implode( ', ' , $_fields );

        $join = isset( $this->clausules['join'] ) ? $this->clausules['join'] : '';

        $command = [];
        $command[] = 'SELECT';
        $command[] = $fields;
        $command[] = 'FROM';
        $command[] = $table;
        if ($join) {
            $command[] = $join;
        }

        $clausules = [
            'where' => [
                'instruction' => 'WHERE' ,
                'separator' => ' ' ,
            ] ,
            'group' => [
                'instruction' => 'GROUP BY' ,
                'separator' => ', ' ,
            ] ,
            'order' => [
                'instruction' => 'ORDER BY' ,
                'separator' => ', ' ,
            ] ,
            'having' => [
                'instruction' => 'HAVING' ,
                'separator' => ' AND ' ,
            ] ,
            'limit' => [
                'instruction' => 'LIMIT' ,
                'separator' => ',' ,
            ] ,
        ];
        foreach ($clausules as $key => $clausule) {
            if (isset( $this->clausules[$key] )) {
                $value = $this->clausules[$key];
                if (is_array( $value )) {
                    $value = implode( $clausule['separator'] , $this->clausules[$key] );
                }
                $command[] = $clausule['instruction'] . ' ' . $value;
            }
        }

        // SELECT {fields} FROM <JOIN> {table} <WHERE> <GROUP> <ORDER> <HAVING> <LIMIT>;
        // junta o comando
        $sql = implode( ' ' , $command );
        var_dump($sql);

        return $this->executeSelect( $sql , $values );
    }

    /**
     * @return int
     */
    public function update()
    {
        // recupera o nome da tabela
        // ou deixa uma marcação para mostrar que faltou informar esse campo
        $table = isset( $this->clausules['table'] ) ? $this->clausules['table'] : '<table>';

        $join = isset( $this->clausules['join'] ) ? $this->clausules['join'] : '';

        // recupera o array dos campos
        // ou deixa uma marcação para mostrar que faltou informar esse campo
        $_fields = isset( $this->clausules['fields'] ) ? $this->clausules['fields'] : '<fields>';


        ksort($_fields);

        $fielDetail = null;

        foreach ($_fields as $key => $values) {
            $fielDetail .= "`$key`=:$key,";
        }

        $fielDetail = trim($fielDetail, ',');

        $command = [];
        $command[] = 'UPDATE';
        $command[] = $table;
        if ($join) {
            $command[] = $join;
        }
        $command[] = 'SET';
        $command[] = $fielDetail;

        $clausules = [
            'where' => [
                'instruction' => 'WHERE' ,
                'separator' => ' ' ,
            ],
            'limit' => [
                'instruction' => 'LIMIT' ,
                'separator' => ',' ,
            ] ,
        ];
        foreach ($clausules as $key => $clausule) {
            if (isset( $this->clausules[$key] )) {
                $value = $this->clausules[$key];
                if (is_array( $value )) {
                    $value = implode( $clausule['separator'] , $this->clausules[$key] );
                }
                $command[] = $clausule['instruction'] . ' ' . $value;
            }
        }

        // UPDATE {table} SET {set} <WHERE>
        // junta o comando
        $sql = implode( ' ' , $command );

        return $this->executeUpdate( $sql , $_fields );
    }

    /**
     * @param $filters
     * @return int
     */
    public function delete($filters = null )
    {
        // recupera o nome da tabela
        // ou deixa uma marcação para mostrar que faltou informar esse campo
        $table = isset( $this->clausules['table'] ) ? $this->clausules['table'] : '<table>';

        $join = isset( $this->clausules['join'] ) ? $this->clausules['join'] : '';

        $command = [];
        $command[] = 'DELETE FROM';
        $command[] = $table;
        if ($join) {
            $command[] = $join;
        }

        $clausules = [
            'where' => [
                'instruction' => 'WHERE' ,
                'separator' => ' ' ,
            ],
            'limit' => [
                'instruction' => 'LIMIT' ,
                'separator' => ',' ,
            ] ,

        ];
        foreach ($clausules as $key => $clausule) {
            if (isset( $this->clausules[$key] )) {
                $value = $this->clausules[$key];
                if (is_array( $value )) {
                    $value = implode( $clausule['separator'] , $this->clausules[$key] );
                }
                $command[] = $clausule['instruction'] . ' ' . $value;
            }
        }

        // DELETE FROM {table} <JOIN> <USING> <WHERE>
        // junta o comando
        $sql = implode( ' ' , $command );

        return $this->executeDelete( $sql , $filters );
    }

    private function executeSelect($sql , $value)
    {

        $stmt = $this->conn->prepare( $sql );

        foreach ($value as $key => $values) {
            return $stmt->bindValue( "$key" , $values );
        }
        $stmt->execute();

        do {
            return $stmt->fetchAll( $fetchMode );
        } while (
            $stmt->nextRowset());
        $stmt->close();

    }

    private function executeInsert($sql , $value)
    {
        try {

            $this->_beginTransaction();

            $stmt = $this->conn->prepare($sql);
            foreach ($value as $key => $values) {
                $stmt->bindValue( ":$key" , $values );
            }
            $this->_commit();
            $stmt->execute();
            unset( $stmt );
        } catch (\Exception $e) {
            $this->_Rollback();
            echo 'error insert ' . $e->getMessage();
        }

    }


    private function executeUpdate($sql , $data)
    {
        $stmt = $this->conn->prepare($sql);
        foreach ($data as $key => $values) {
            $stmt->bindValue(":$key", $values);
        }

        return $stmt->execute();
    }

    private function executeDelete($sql , $value)
    {
        return $this->conn->exec($sql);

    }
}