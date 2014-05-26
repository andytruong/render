<?php

namespace AndyTruong\Render\TestCases\Renders;

use AndyTruong\Render\TestCases\TestCase;

/**
 * If our callback can not be autoloaded. Using this feature to do that:
 *
 *  $input = array(
 *      array('type' => 'twig', 'value' => "{{ 'Hello' ~ ' ' ~ 'PHP' }}"),
 *  );
 *  $output = at_render($input); // Output: 'Hello PHP'
 *
 */
class TwigRenderTest extends TestCase
{

    /**
     * @dataProvider dataProviderTwigString
     */
    public function testTwigString($expecting, $input)
    {
        $input = array('source' => array('type' => 'twig', 'value' => $input));
        $this->assertEquals($expecting, at_render($input));
    }

    public function dataProviderTwigString() {
        return array(
            array('Hello PHP',  "{{ 'Hello' ~ ' ' ~ 'PHP' }}"),
            array('Hello Twig', "{% if true %}Hello Twig{% endif %}")
        );
    }

}
