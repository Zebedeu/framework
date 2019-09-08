<?php

namespace Ballybran\Core\REST;

class EncodeContainer
{

    private $encode;

    public function __construct(EncodeText $encode)
    {
        $this->encode = $encode;
    }


    public function getEnodeType($text)
    {

        $this->encode->encodeXml($text);
    }

}