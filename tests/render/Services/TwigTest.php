<?php

namespace AndyTruong\Render\TestCases\Services;

use AndyTruong\Render\Factories\TwigFactory;
use Twig_SimpleFilter;
use Zend\EventManager\EventManager;

class TwigTest extends \PHPUnit_Framework_TestCase
{

    public function testTwigFactory()
    {
        $this->assertInstanceOf('Twig_Environment', at_twig());
    }

    public function testFactoryOptions()
    {
        $factory = new TwigFactory();

        $factory
            ->getDispatcher()
            ->attach('at.twig.factory.options', function ($e) {
                return array('debug' => true, 'foo' => 'bar');
            });

        $options = $factory->getOptions();
        $this->assertTrue($options['debug']);
        $this->assertEquals('bar', $options['foo']);
    }

    public function testCustomFilter()
    {
        $em = new EventManager();
        $em->attach('at.twig.extension.filters', function ($e) {
            $filters[] = new Twig_SimpleFilter('at_common_print', 'print_r');
            return $filters;
        });
        at_event_manager('at.twig.extension', $em);

        $this->assertInstanceOf('Twig_SimpleFilter', at_twig($refresh = true)->getFilter('at_common_print'));
    }

}
