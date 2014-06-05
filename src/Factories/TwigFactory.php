<?php

namespace AndyTruong\Render\Factories;

use Twig_Environment,
    AndyTruong\Render\TwigExtension,
    AndyTruong\Common\EventAware;

/**
 * Class to create Twig enviroment object.
 *
 * @event at.twig.factory.options  Twig-environment options are alterable on this event.
 * @event at.twig.factory.init     On Twig-environment initialized.
 * @see at_twig()
 */
class TwigFactory extends EventAware
{

    /**
     * Name of event-manager.
     *
     * @var string
     */
    protected $em_name = 'at.twig.factory';

    /**
     * Get options for Twig-environment.
     *
     * @return array
     */
    public function getOptions()
    {
        $options = array();

        foreach ($this->getEventManager()->trigger('at.twig.factory.options') as $_options) {
            if (is_array($_options)) {
                $options = array_merge($options, $_options);
            }
        }

        return $options + array(
            'debug' => FALSE,
            'auto_reload' => FALSE,
            'autoescape' => FALSE,
            'cache' => '/tmp',
        );
    }

    /**
     * Get main Twig extension.
     */
    public function getTwigExtension()
    {
        return new TwigExtension();
    }

    /**
     * Get Twig enviroment object.
     *
     * @return \Twig_Environment
     */
    public function getTwigEnvironment()
    {
        $twig = new Twig_Environment(NULL, $this->getOptions());
        $twig->addExtension($this->getTwigExtension());
        $this->getEventManager()->trigger('at.twig.factory.init', $twig);
        return $twig;
    }

}
