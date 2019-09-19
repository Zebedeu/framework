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

namespace Ballybran\Core\Collections\Collection;

use Traversable;

/**
 * Description of Colections
 *
 * @author artphotografie
 */
interface CollectionInterface extends Traversable
{

    /**
     * @return mixed
     */
    public function getIterator();

    /**
     * @param $offset
     * @return mixed
     */
    public function offsetExists($offset);

    /**
     * @param $offset
     * @return mixed
     */
    public function offsetGet($offset);

    /**
     * @param $offset
     * @param $value
     * @return mixed
     */
    public function offsetSet($offset, $value);

    /**
     * @param $offset
     * @return mixed
     */
    public function offsetUnset($offset);

//put your code here
}
