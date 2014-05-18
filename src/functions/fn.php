<?php

use AndyTruong\Render\Render;

/**
 * Wrapper function to render input.
 *
 * @param type $input
 * @return type
 */
function at_render($input) {
    return at_id(new Render())->render($input);
}
