<?php
/**
 * Created by PhpStorm.
 * User: marciozebedeu
 * Date: 8/3/19
 * Time: 4:12 PM
 */

namespace Ballybran\Helpers\Event;


interface iEventBase
{

    public function __construct(InterfaceEventCollection $events , InterfaceEventHandlerCollection $handlers
    = null);

    public function __destruct();

    public function registerEventHandler($handler);

    public function notify($listEventName);

    public function triggerEvent($eventName , $args);

}