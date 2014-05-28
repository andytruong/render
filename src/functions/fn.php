<?php

use AndyTruong\Render\RenderManager,
    AndyTruong\Common\Factories\TwigFactory;

/**
 * Wrapper function to render input.
 *
 * @param string|array $input
 * @return string
 */
function at_render($input) {
    if (is_string($input)) {
        $input = array('source' => array('type' => 'string', 'value' => $input));
    }

    return at_id(new RenderManager())->render($input);
}

/**
 * Return Twig environment class.
 *
 * @staticvar Twig_Environment $twig
 * @return Twig_Environment
 */
function at_twig($refresh = false)
{
    static $twig;

    if ($refresh || is_null($twig)) {
        $twig = at_id(new TwigFactory())->getTwigEnvironment();
    }

    return $twig;
}
