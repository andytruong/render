<?php

namespace AndyTruong\Render;

use AndyTruong\Render\Processing\Conditions as ConditionsProcessing;

/**
 * @todo SourceMaker must be pluggable.
 */
class RenderManager extends RenderManagerBase
{

    protected $process = true;

    public function render($input = NULL)
    {
        if (!is_null($input)) {
            if (is_string($input)) {
                $input = array('source' => array('type' => 'string', 'value' => $input));
            }
            $this->setInput($input);
        }

        return $this->build();
    }

    protected function build()
    {
        $return = array();

        foreach ($this->input as $key => $value) {
            if (!empty(self::$input_callbacks[$key])) {
                foreach (self::$input_callbacks[$key] as $callback) {
                    $return[$key][] = call_user_func_array($callback, array($value));
                }
            }
        }

        return (string) $this->getOutput();
    }

    public function processSource($source)
    {
        if (!$this->process) {
            return;
        }

        $output = $this->getOutput();

        $render_id = $source['type'];
        $render_input = $source['value'];

        if ($render = $this->getRender($render_id)) {
            $arguments = array(); // @todo Implement me
            $output[] = $render->render($render_input, $arguments);
        }
    }

    public function processFile($file)
    {
        include_once $file;
    }

    public function processFiles($files)
    {
        foreach ($files as $file) {
            include_once $file;
        }
    }

    public function processCondition($callback)
    {
        if (!is_callable($callback)) {
            throw new \Exception('Invalidate condition callback.');
        }

        if (!call_user_func_array($callback, array($this))) {
            $this->process = false;
        }
    }

    public function processConditions($conditions)
    {
        $processing = new ConditionsProcessing($conditions);
        if (!$processing->check($this)) {
            $this->process = false;
        }
    }

}
