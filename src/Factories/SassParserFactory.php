<?php

namespace AndyTruong\Render\Factories;

use AndyTruong\Common\EventAware;

class SassParserFactory extends EventAware
{
    /**
     * Name of event-manager.
     *
     * @var string
     */
    protected $em_name = 'at.sass.factory';

    /**
     * Get options for Twig-environment.
     *
     * @return array
     */
    public function getOptions()
    {
        $options = array();

        foreach ($this->getDispatcher()->trigger('at.sass.factory.options') as $_options) {
            if (is_array($_options)) {
                $options = array_merge($options, $_options);
            }
        }

        return $options + array(
            'style' => 'nested',
            'cache' => false,
            'syntax' => 'sass',
            'debug' => false,
            'debug_info' => false,
        );
    }
}
