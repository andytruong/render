<?php

namespace AndyTruong\Render\TestCases;

class StringTest extends TestCase {
  /**
   * @dataProvider dataProvider
   */
  public function testString($input, $msg) {
    $this->assertEquals($input, $this->getRender()->render($input), $msg);
  }

  public function dataProvider() {
    return array(
      array('Hello PHP', 'Basic ASCII string'),
      array('Xin chào ngôn ngữ PHP', 'Vietnamese string'),
      array('Hi PHP…', 'Special chars'),
    );
  }

  /**
   * @dataProvider negativeDataProvider
   */
  public function testNotEqual($unexpected, $input, $msg) {
    $this->assertNotEquals($unexpected, $this->getRender()->render($input), $msg);
  }

  public function negativeDataProvider() {
    return array(
      array('Hello PHP!', 'Hello PHP', 'Basic ASCII string'),
      array('Xin chào ngôn ngữ PHP!', 'Xin chào ngôn ngữ PHP', 'Vietnamese string'),
      array('Hi PHP… ^^', 'Hi PHP…', 'Special chars'),
    );
  }
}
