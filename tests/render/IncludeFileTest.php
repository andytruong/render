<?php

namespace AndyTruong\Render\TestCases;

/**
 * If our callback can not be autoloaded. Using this feature to do that:
 *
 *  $input = array(
 *      array('source' => 'callback', 'value' => 'my_callback_function'),
 *      'file' => 'path/to/my/file.php'
 *  );
 *  $output = at_render($input);
 *
 */
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

        $function_files = array(
            'files' => array(
                __DIR__ . '/Fixtures/IncludingFiles/function.php',
                __DIR__ . '/Fixtures/IncludingFiles/function_2.php'
            ),
            'source' => array('type' => 'callback', 'value' => 'at_render_test_callback_2'),
        );

        return array(
            array($function),
            array($class),
            array($function_files)
        );
    }
}
