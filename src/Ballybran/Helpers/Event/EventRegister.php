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
 * Time: 06:41
 */

namespace Ballybran\Helpers\Event;


class EventRegister
{

    /**
     * @param $events array
     * Holds registered events
     */
    private $events;

    // CONSTRUCTORS
    function __construct() {
        $this->events;
    }

    // MANIPULATORS

    /**
     * Registers an event
     * @param $eventName string. For example the <i>name</i> of
     * a $_GET variable
     * e.g. index.php?action=foo. $eventHandler="action";
     *
     * @param $eventHandler string. the name of the handler for that event
     *
     */
    function register ($eventName,$eventHandler) {
        $this->events[$eventName]=$eventHandler;
    }

    // ACCESSORS

    /**
     * Returns the parameters for an event
     * @param $eventName string.
     * @return - either array or false
     * if event does not exist.
     *
     */
    function getByName ($eventName) {
        if ( isset ( $this->events[$eventName] ) ) {
            return $this->events[$eventName];
        } else {
            return false;
        }
    }

    /**
     * Returns the complete events array
     * @return - array of events to their param names.
     *
     */
    function getAll () {
        return $this->events;
    }

}
