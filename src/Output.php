<?php

namespace AndyTruong\Render;

use AndyTruong\Common\Context;

class Output extends Context
{
    protected $container = array();

    public function __toString()
    {
        return implode('', $this->container);
    }

}
