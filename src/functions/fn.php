<?php

use AndyTruong\Render\RenderManager;

/**
 * Wrapper function to render input.
 *
 * @param type $input
 * @return type
 */
function at_render($input) {
    return at_id(new RenderManager())->render($input);
}
