<?php

namespace AndyTruong\Render\TestCases;

/**
 * When we one do something extra before/after rending the input, we can use
 * this features.
 *
 *      $input = array(
 *          'source' => array('type' => 'string', 'value' => 'Hello PHP!'),
 *          'before' => array($callback1, $callback2),
 *          'after'  => array($callback3, $callback4)
 *      );
 */
class CallBeforeAfterTest extends TestCase
{

    /**
     * @dataProvider dataProviderCalling
     */
    public function testCalling($position)
    {
        $called = false;

        $input = array(
            'source' => array('type' => 'string', 'value' => 'Hello PHP!'),
            $position => array(
                function($render_manager) use (&$called) {
                $called = true;
            }
            ),
        );

        at_render($input);

        $this->assertTrue($called);
    }

    public function dataProviderCalling()
    {
        return array(
            array('before'),
            array('after'),
        );
    }

}
