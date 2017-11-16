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

/**
 * Created by PhpStorm.
 * User: artphotografie
 * Date: 09/01/17
 * Time: 08:57
 */

namespace Ballybran\Core\Collections;


class CollectionObject
{

    private $id;
    private $object;

    /**
     * CollectionObject constructor.
     * @param $_id
     * @param $_object
     */
    public function __construct( $_id, $_object )
    {

        $this->id = $_id;
        $this->object = $_object;
    }

    function getObject()
    {
        return $this->object;
    }

    function printObject()
    {
        print_r($this);
    }
}