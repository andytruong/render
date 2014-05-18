<?php

namespace AndyTruong\Render\TestCases;

use AndyTruong\Render\RenderManager;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @return \AndyTruong\Render\RenderManager
     */
    protected function getRenderManager()
    {
        return new RenderManager();
    }

}
