<?php

namespace Ballybran\Helpers\Event;

interface InterfaceEventHandlerCollection
{
    public function add($handler);

    public function raiseEvent($event, $sender, $args);
}
