<?php

namespace AndyTruong\Render;

use AndyTruong\Common\EventAware;

abstract class BaseRender extends EventAware
{

    /**
     * Name of event-manager.
     *
     * @var string
     */
    protected $em_name = 'at_render.extension.register';

    /**
     *
     * @var string
     */
    protected $prefix;

    /**
     *
     * @var string
     */
    protected $suffix;

    /**
     *
     * @var array
     */
    protected $conditions;

    /**
     *
     * @var mixed
     */
    protected $source;

    /**
     *
     * @var array
     */
    protected $call_before;

    /**
     *
     * @var array
     */
    protected $call_after;

    /**
     * File to be loaded before rendering.
     *
     * @var string
     */
    protected $file;
    protected static $renders = array();

    public function __construct()
    {
        $this->registerRender('string', 'AndyTruong\Render\Render\String', false);
        $this->registerRender('callback', 'AndyTruong\Render\Render\Callback', false);
    }

    public function registerRender($render_id, $class, $raise_error = true)
    {
        if (isset(self::$renders[$render_id])) {
            if ($raise_error) {
                throw new \Exception(sprintf('Render %s is already registered', strip_tags($render_id)));
            }
            return;
        }
        self::$renders[$render_id] = $class;
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
        $keys = array('file', 'prefix', 'suffix', 'conditions', 'source');
        foreach ($keys as $key) {
            if (isset($input[$key])) {
                $method = 'set' . ucfirst($key);
                $this->{$method}($input[$key]);
            }
        }
    }

    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * Set source property.
     *
     * @param mixed $source
     */
    public function setSource($source)
    {
        $this->source = $source;
    }

    /**
     * Set prefix property.
     *
     * @param string $string
     */
    public function setPrefix($string)
    {
        $this->prefix = $string;
    }

    /**
     * Set suffix property.
     *
     * @param string $string
     */
    public function setSuffix($string)
    {
        $this->suffix = $string;
    }

    /**
     * Set conditions property.
     *
     * @param array $conditions
     */
    public function setConditions($conditions)
    {
        $this->conditions = $conditions;
    }

    /**
     * Set call_before property.
     *
     * @param array $calls
     */
    public function setCallBefore($calls)
    {
        $this->call_before = $calls;
    }

    /**
     * Set call_after property.
     *
     * @param array $calls
     */
    public function setCallAfter($calls)
    {
        $this->call_after = $calls;
    }

}
