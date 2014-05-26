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

    public function dataProviderTwigString()
    {
        return array(
            array('Hello PHP', "{{ 'Hello' ~ ' ' ~ 'PHP' }}"),
            array('Hello Twig', "{% if true %}Hello Twig{% endif %}")
        );
    }

    /**
     * Render string with arguments.
     *
     * @param string $input
     * @param array $arguments
     * @dataProvider dataProviderTwigStringWithArguments
     */
    public function testTwigStringWithArguments($expecting, $input, $arguments)
    {
        $input = array(
            'source' => array('type' => 'twig', 'value' => $input),
            'arguments' => $arguments
        );
        $this->assertEquals($expecting, at_render($input));
    }

    public function dataProviderTwigStringWithArguments()
    {
        $data = array();

        // String
        $data[] = array('Hello PHP!', 'Hello {{ name }}!', array('name' => 'PHP'));

        // Array
        $project = array('language' => 'PHP');
        $data[] = array('Hello PHP!', 'Hello {{ project.language }}!', array('project' => $project));

        // Object
        $language = new \stdClass();
        $language->name = 'PHP';
        $data[] = array('Hello PHP!', 'Hello {{ language.name }}!', array('language' => $language));

        return $data;
    }

}
