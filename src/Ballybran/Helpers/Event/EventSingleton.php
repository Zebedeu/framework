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
 * User: macbookpro
 * Date: 08/11/17
 * Time: 06:43
 */

namespace Ballybran\Helpers\Event;


class EventSingleton
{


    /**
     * @param $instance object
     * Holds and instance of the EventRegister class
     */
    static $instance;
    /**
     * Creates a new EventRegister object if none found
     * @return object
     */
    function getEventSingleton () {
        if(!isset(self::$instance)) {
            self::$instance = new EventRegister();
        }


    /**
     * Returns the EventRegister object
     * @return object
     */
        return self::$instance;
    }
}