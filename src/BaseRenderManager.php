<?php

namespace AndyTruong\Render;

use AndyTruong\Common\EventAware;
use Zend\Stdlib\SplStack;

abstract class BaseRenderManager extends EventAware
{

    /**
     * Name of event-manager.
     *
     * @var string
     */
    protected $em_name = 'at_render.extension.register';

    /**
     * Input array
     *
     * @var array
     */
    protected $input;

    /**
     * Output.
     *
     * @var Output
     */
    protected $output;

    /**
     * Render plugins.
     *
     * @var array
     */
    protected static $renders = array();

    /**
     * @todo Priority is important, for examples:
     *      - `before`, `file` must be processed before `source`
     *      - `after' must be processed after `source`
     * @var SplStack
     */
    protected static $input_callbacks;

    public function __construct()
    {
        $this->registerDefaultRenders();
        $this->registerDefaultInputCallbacks();
    }

    protected function registerDefaultRenders() {
        if (empty(self::$renders)) {
            $this->registerRender('string', 'AndyTruong\Render\Render\String');
            $this->registerRender('callback', 'AndyTruong\Render\Render\Callback');
        }
    }

    protected function registerDefaultInputCallbacks() {
        self::$input_callbacks = array(
            'condition' => array(),
            'conditions' => array(),
            'file' => array(),
            'files' => array(),
            'source' => array(),
        );

        $this->registerInputCallbacks('condition', 'default', array($this, 'processCondition'));
        $this->registerInputCallbacks('conditions', 'default', array($this, 'processConditions'));

        $this->registerInputCallbacks('file', 'default', function($file) {
            include_once $file;
        });

        $this->registerInputCallbacks('files', 'default', function($files) {
            foreach ($files as $file) {
                include_once $file;
            }
        });

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
     * Wrapper method to set object properties.
     *
     * @param string|array $input
     */
    public function setInput($input)
    {
        if (!is_array($input)) {
            throw new \Exception('Input but me an array.');
        }

        $this->input = $input;
    }

    public function getInput() {
        return $this->input;
    }

    public function getOutput() {
        if (is_null($this->output)) {
            $this->output = new Output();
        }

        return $this->output;
    }
}
