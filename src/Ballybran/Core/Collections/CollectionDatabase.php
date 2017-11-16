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

namespace Ballybran\Core\Collections;

use ArrayObject;

class CollectionDatabase
{

    private $data;

    function __construct()
    {
        $this->data = new ArrayObject();
    }

    function addObject( $_id, $_object )
    {
        $_thisItem = new CollectionObject($_id, $_object);
        $this->data->offSetSet($_id, $_thisItem);
    }

    function deleteObject( $_id )
    {
        $this->data->offsetUnset($_id);
    }

    function getObject( $_id )
    {
        $_thisObject = $this->data->offSetGet($_id);
        return $_thisObject->getObject();
    }

    function printCollection()
    {
        print_r($this->data);
    }
}