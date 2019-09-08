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
            echo $this->events[] = $event;
        }
    }

    /**
     * @param $handler ->getEventName
     * @return bool|mixed
     */
    public function contains($event)
    {
        echo $event;
        foreach ($this->events as $e) {
            if ($e->getName() == $event) {
                return true;
            }
        }
    }
}
