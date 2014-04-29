<?php

namespace AndyTruong\Render\TestCases;

class StringTest extends TestCase {
  public function testOk() {
    $render = $this->getRender();
    $expected = 'Hello PHP';
    $actual = $render->render($expected);
    $this->assertEquals($expected, $actual);
  }
}
