<?php

namespace AndyTruong\Render\TestCases;

class StringTest extends TestCase {
  /**
   * @dataProvider dataProvider
   */
  public function testString($input, $msg = '') {
    $this->assertEquals($input, $this->getRender()->render($input));
  }

  public function dataProvider() {
    return array(
      array('Hello PHP', 'Basic ASCII string'),
      array('Xin chào ngôn ngữ PHP', 'Vietnamese string'),
      array('Hi PHP…', 'Special chars'),
    );
  }
}
