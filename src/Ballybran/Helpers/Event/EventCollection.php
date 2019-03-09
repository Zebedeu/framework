<?php

namespace Ballybran\Helpers\Event;

class EventCollection implements InterfaceEventCollection
{
    private $events = array();

    public function __construct()
    {
    }

    public function add($event)
    {
        if (!$this->contains($event)) {
            $this->events[] = $event;
        }
    }

    public function contains($event)
    {
        foreach ($this->events as $e) {
            if ($e->getName() == $event) {
                return true;
            }
        }
    }
}
