<?php

namespace AndyTruong\Render\Render;

class TwigRender implements RenderInterface
{

    public function render($template, $arguments = array())
    {
        return at_twig()->render($template, $arguments);
    }

}
