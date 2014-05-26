<?php

namespace AndyTruong\Render\TestCases\Renders;

use AndyTruong\Render\TestCases\TestCase;

class StringRenderTest extends TestCase
{

    /**
     * @dataProvider dataProvider
     */
    public function testString($string, $msg)
    {
        $array = array('source' => array('type' => 'string', 'value' => $string));

        $this->assertEquals($string, at_render($string), $msg);
        $this->assertEquals($string, at_render($array), $msg);
    }

    public function dataProvider()
    {
        return array(
            array('Hello PHP', 'Basic ASCII string'),
            array('Xin chào ngôn ngữ PHP', 'Vietnamese string'),
            array('Hi PHP…', 'Special chars'),
        );
    }

    /**
     * @dataProvider negativeDataProvider
     */
    public function testNotEqual($string, $input, $msg)
    {
        $array = array('source' => array('type' => 'string', 'value' => $input));

        $this->assertNotEquals($string, at_render($input), $msg);
        $this->assertEquals($input, at_render($array), $msg);
    }

    public function negativeDataProvider()
    {
        return array(
            array('Hello PHP!', 'Hello PHP', 'Basic ASCII string'),
            array('Xin chào ngôn ngữ PHP!', 'Xin chào ngôn ngữ PHP', 'Vietnamese string'),
            array('Hi PHP… ^^', 'Hi PHP…', 'Special chars'),
        );
    }

}
