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
 * Copyright (c) 2017.  APWEB  Software Technologies AO Inc. (http://www.artphoweb.com)
 * @license   http://framework.artphoweb.com/license/new-bsd New BSD License
 * @author    Marcio Zebedeu - artphoweb@artphoweb.com
 * @version   1.0.0
 */
namespace FWAP\Core\FWCols\FWAPColections;

/**
 * Description of Colections
 *
 * @author artphotografie
 */
interface Colections  {

public function getIterator();

public function offsetExists($offset);

public function offsetGet($offset);

public function offsetSet($offset, $value);

public function offsetUnset($offset);


//put your code here
}
