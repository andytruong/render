<?php

namespace AndyTruong\Render;

use AndyTruong\Common\EventAware;

/**
 * RenderManagerSystem, provider methods for external code can extends render
 * system.
 */
abstract class RenderManagerSystem extends EventAware
{

    /**
     * Name of event-manager.
     *
     * @var string
     */
    protected $em_name = 'at_render.extension.register';

    /**
     * Render plugins.
     *
     * @var array
     */
    protected static $renders = array();

    /**
     *
     * @param string $render_id
     * @return \AndyTruong\Render\Render\RenderInterface
     */
    public function getRender($render_id)
    {
        if (isset(self::$renders[$render_id])) {
            $render = new self::$renders[$render_id];
            return $render;
        }
    }

    /**
     * @todo Priority is important, for examples:
     *      - `before`, `file` must be processed before `source`
     *      - `after' must be processed after `source`
     * @var SplStack
     */
    protected static $input_callbacks = array();

    public function __construct()
    {
        $this->registerDefaultRenders();
        $this->registerDefaultInputCallbacks();
    }

    protected function registerDefaultRenders()
    {
        if (empty(self::$renders)) {
            $this->registerRender('string', 'AndyTruong\Render\Render\String');
            $this->registerRender('callback', 'AndyTruong\Render\Render\Callback');
        }
    }

    protected function registerDefaultInputCallbacks()
    {
        self::$input_callbacks = array(
            'condition' => array(),
            'conditions' => array(),
            'file' => array(),
            'files' => array(),
            'source' => array(),
        );

        $this->registerInputCallbacks('condition', 'default', array($this, 'processCondition'));
        $this->registerInputCallbacks('conditions', 'default', array($this, 'processConditions'));
        $this->registerInputCallbacks('file', 'default', array($this, 'processFile'));
        $this->registerInputCallbacks('files', 'default', array($this, 'processFiles'));
        $this->registerInputCallbacks('source', 'default', array($this, 'processSource'));
    }

    public function registerRender($render_id, $class)
    {
        if (isset(self::$renders[$render_id])) {
            throw new \Exception(sprintf('Render %s is already registered', strip_tags($render_id)));
        }
        self::$renders[$render_id] = $class;
    }

    public function registerInputCallbacks($key, $id, $callback)
    {
        if (!is_callable($callback)) {
            throw new \Exception(sprintf('Invalid callback for %s', strip_tags($key)));
        }
        self::$input_callbacks[$key][$id] = $callback;
    }

}
