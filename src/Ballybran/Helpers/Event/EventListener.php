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

/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 08/11/17
 * Time: 06:44
 */

namespace Ballybran\Helpers\Event;


class EventListener
{

    var $eventRegister;

    var $get;

    // CONSTRUCTORS
    function EventListener()
    {
        $eventReg =& new EventSingleton();
        $this->eventRegister = $eventReg->getEventSingleton();
        $this->findCurrentEvents();
    }

    // MANIPULATORS

    /**
     * Searches the $_GET global looking for registered events
     * and stores in a local variable for triggering
     * @return - no return value
     *
     */
    function findCurrentEvents()
    {
        $events = $this->eventRegister->getAll();
        foreach ($events as $eventName => $eventHandler ) {
        if (isset ($_GET[$eventName])) {
            $this->get[$eventName] = $eventHandler;
        }
    }
    }

    // ACCESSORS

    /**
     * Triggers handler classes from current events
     * @return - no return value
     *
     */
    function trigger()
    {
        if (isset($this->get)) {
            foreach ($this->get as $eventName => $eventHandler) {
                $$eventHandler =& new $eventHandler;
                $$eventHandler->respond();
            }
        } else {
            // Do default handler if no events
            $defaultHandler =& new DefaultHandler;
        }
    }
}