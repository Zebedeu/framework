<?php

namespace Ballybran\Helpers\Event;

interface InterfaceEventCollection
{
    public function add($event);

    public function contains($event);
}
