<?php

namespace AndyTruong\Render\Render;

interface RenderInterface
{

    /**
     * Render input value.
     */
    public function render($input, $arguments = array());
}
