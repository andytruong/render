<?php

namespace AndyTruong\Render\TestCases;

/**
 * Use this feature in case we need render the input with some condition checkings.
 *
 *  $input = array(
 *      'source' => array('type' => 'string', 'value' => 'You are using too old PHP version.'),
 *      'condition' => function() {
 *          return version_compare(PHP_VERSION, '5.3.0', '<')
 *      },
 *  );
 *  $output = at_render($input);
 *
 * We can use multiple conditions at one (Input is only rendered if all the
 * conditions checkings return true):
 *
 *  $input = array(
 *      'source' => array('type' => 'string', 'value' => '…'),
 *      'conditions' => array(
 *          function() { return true; },
 *          function() { return true;},
 *      )
 *  );
 *  $output = at_render($input);
 *
 * When using multiple conditions, we can specify custom logical operator instead
 * of 'and' by default.
 *
 *  $input = array(
 *      'source' => array('type' => 'string', 'value' => '…'),
 *      'conditions' => array(
 *          'type'       => 'xor', // available options: and, or, xor, not
 *          'conditions' => array(
 *              function() { return true; },
 *              function() { return true; },
 *          ),
 *      )
 *  );
 *  $output = at_render($input);
 */
class ConditionsTest extends TestCase
{

    public function testSingleConditionTrue()
    {
        $input = array(
            'condition' => function($manager) {
            return true;
        },
            'source' => array('type' => 'string', 'value' => 'Hello PHP'),
        );
        $output = at_render($input);
        $this->assertNotEmpty($output);
    }

    public function testSingleConditionFalse()
    {
        $input = array(
            'condition' => function() {
            return false;
        },
            'source' => array('type' => 'string', 'value' => 'Hello C++'),
        );
        $output = at_render($input);
        $this->assertEmpty($output);
    }

    /**
     *
     * @dataProvider dataProviderMultipleConditionsDefaultlogicalOperation
     */
    public function testMultipleConditionsDefaultLogicalOperation($conditions, $empty)
    {
        $input = array(
            'conditions' => $conditions,
            'source' => array('type' => 'string', 'value' => 'Hello PHP'),
        );
        $output = at_render($input);

        $empty ? $this->assertEmpty($output) : $this->assertNotEmpty($output);
    }

    public function dataProviderMultipleConditionsDefaultLogicalOperation()
    {
        $true = function() {
            return true;
        };
        $false = function() {
            return false;
        };

        return array(
            array(array($true, $true), false),
            array(array($true, $false), true),
            array(array($false, $true), true),
            array(array($false, $false), true),
        );
    }

    /**
     * @dataProvider dataProviderMultipleConditionsWithLogicalOperation
     */
    public function testMultipleConditionsWithLogicalOperation($operation, $conditions, $empty)
    {
        $input = array(
            'conditions' => array('type' => $operation, 'conditions' => $conditions),
            'source' => array('type' => 'string', 'value' => 'Hello PHP'),
        );
        $output = at_render($input);

        $empty ? $this->assertEmpty($output) : $this->assertNotEmpty($output);
    }

    public function dataProviderMultipleConditionsWithLogicalOperation()
    {
        $true = function() {
            return true;
        };
        $false = function() {
            return false;
        };

        return array(
            array('and', array($true,  $true),  false),
            array('and', array($true,  $false), true),
            array('and', array($false, $true),  true),
            array('and', array($false, $false), true),
            array('or', array($true,   $true),  false),
            array('or', array($true,   $false), false),
            array('or', array($false,  $true),  false),
            array('or', array($false,  $false), true),
            array('xor', array($true,  $true),  true),
            array('xor', array($true,  $false), false),
            array('xor', array($false, $true),  false),
            array('xor', array($false, $false), true),
        );
    }

}
