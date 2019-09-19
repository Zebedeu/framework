<?php

namespace Ballybran\Helpers\Event;

class EventHandler
{
    private $event;
    private $callback;

    public function __construct($event, $callback)
    {
        $this->event = $event;
        $this->callback = $this->prepareCallback($callback);
    }

    public function getEventName()
    {
        return $this->event->getName();
    }

    public function raise($sender, $args)
    {
        if ($this->callback) {
            eval($this->callback);
        }

        return $args;
    }

    private function prepareCallback($callback)
    {
        if ($pos = strpos($callback, '(')) {
            $callback = substr($callback, 0, $pos);
        }

        $callback .= '($sender,  $args);';

        return $callback;
    }
}
