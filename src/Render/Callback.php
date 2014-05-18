<?php

namespace AndyTruong\Render\Render;

class Callback implements RenderInterface
{

    public function render($input, $arguments = array())
    {
        if (!is_callable($input)) {
            throw new \Exception('Input is not a valid callback');
        }

        return call_user_func_array($input, $arguments);
    }

}
