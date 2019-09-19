<?php

namespace Ballybran\Helpers\Event;

interface InterfaceEventClass
{
    public function __construct(InterfaceEventCollection $events , InterfaceEventHandlerCollection $handlers = null);

    public function notify($listEventName);

    public function triggerEvent($eventName , $args);
}
