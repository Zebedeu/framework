<?php

namespace Ballybran\Helpers\Event;

interface InterfaceEventCollection
{
    public function add($event);


    /**
     * @param $event
     * @return mixed
     */
    public function contains($event);
}
