<?php

namespace AndyTruong\Render\TestCases;

class IncludeFileTest extends TestCase
{

    /**
     * @dataProvider dataProvider
     */
    public function testIncludeFile($input) {
        $output = at_render($input);
        $this->assertNotNull($output);
    }

    public function dataProvider() {
        $function = array(
            'file' => __DIR__ . '/Fixtures/IncludingFiles/function.php',
            'source' => array('type' => 'callback', 'value' => 'at_render_test_callback'),
        );

        $class = array(
            'file' => __DIR__ . '/Fixtures/IncludingFiles/class.php',
            'source' => array('type' => 'callback', 'value' => 'AndyTruong\Render\TestCases\Fixtures\IncludingFiles_Callback::render'),
        );

        return array(
            array($function),
            array($class)
        );
    }
}
