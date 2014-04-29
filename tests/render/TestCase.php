<?php

namespace AndyTruong\Render\TestCases;

abstract class TestCase extends \PHPUnit_Framework_TestCase {
  protected function getRender() {
    return new \AndyTruong\Render\Render();
  }
}
