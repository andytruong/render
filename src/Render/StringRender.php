<?php

namespace AndyTruong\Render\Render;

class StringRender implements RenderInterface
{

    public function render($input, $arguments = array())
    {
        if (!is_string($input)) {
            throw new \Exception('Input is not a valid string');
        }

        return $input;
    }

}
