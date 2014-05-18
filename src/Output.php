<?php

namespace AndyTruong\Render;

use AndyTruong\Common\Context;

class Output extends Context
{

    public function __toString()
    {
        return implode('', $this->container);
    }

}
