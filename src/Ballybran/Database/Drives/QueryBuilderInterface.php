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


namespace Ballybran\Database\Drives;


/**
 * Class QueryBuilder
 * @package Hero
 * @method QueryBuilder table (string $table)
 * @method QueryBuilder join (string $join)
 * @method QueryBuilder fields (array $fields)
 * @method QueryBuilder where (array $where)
 * @method QueryBuilder order (array $order)
 * @method QueryBuilder group (array $group)
 * @method QueryBuilder having (array $having)
 * @method QueryBuilder limit (array $join)
 */
class QueryBuilderInterface
{

    /**
     * @param $name
     * @param $arguments
     * @return $this
     */
    function __call($name, $arguments);

    /**
     * QueryBuilder constructor.
     * @param array $options
     */
    public function __construct(array $options);

    /**
     * @param array $values
     * @return string
     */
    public function insert($values);

    /**
     * @param $values
     * @return string
     */
    public function select($values = []);

    /**
     * @param $values
     * @param $filters
     * @return int
     */
    public function update($values, $filters = []);

    /**
     * @param $filters
     * @return int
     */
    public function delete($filters);
}