<?php

namespace AndyTruong\Render\Render;

class String implements RenderInterface
{

    public function render($input, $arguments = array())
    {
        if (!is_string($input)) {
            throw new \Exception('Input is not a valid string');
        }

        return $input;
    }

}
