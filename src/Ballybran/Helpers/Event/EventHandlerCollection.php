<?php

namespace Ballybran\Helpers\Event;

class EventHandlerCollection implements InterfaceEventHandlerCollection
{
    private $handlers = array();

    public function __construct()
    {
        $this->handlers = array();
    }

    public function add($handler)
    {
        $this->handlers[] = $handler;
    }

    public function raiseEvent($event , $sender , $args)
    {
        foreach ($this->handlers as $handler) {
            if ($handler->getEventName() == $event) {
                $handler->raise($sender , $args);
            }
        }
    }
}
