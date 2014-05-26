<?php

namespace AndyTruong\Render;

use AndyTruong\Render\Processing\Conditions as ConditionsProcessing;

/**
 * Abtract class to provide processing methods for RenderManagerSystem.
 */
abstract class RenderManagerProcessing extends RenderManagerSystem
{

    public function processSource($source)
    {
        $output = $this->getOutput();

        $render_id = $source['type'];
        $render_input = $source['value'];

        if ($render = $this->getRender($render_id)) {
            $arguments = $this->getArguments();
            $output[] = $render->render($render_input, $arguments);
        }
    }

    /**
     * Callback to process $input['file']
     *
     * @param string $file
     */
    public function processFile($file)
    {
        include_once $file;
    }

    /**
     * Callback to process $input['files']
     *
     * @param array $files
     */
    public function processFiles($files)
    {
        foreach ($files as $file) {
            include_once $file;
        }
    }

    /**
     * Callback to process $input['condition']
     *
     * @param callable $callback
     * @throws \Exception
     */
    public function processCondition($callback)
    {
        if (!is_callable($callback)) {
            throw new \Exception('Invalidate condition callback.');
        }

        if (!call_user_func_array($callback, array($this))) {
            $this->process = false;
        }
    }

    /**
     * Callback to process $input['conditions']
     *
     * @param array $conditions
     */
    public function processConditions($conditions)
    {
        $processing = new ConditionsProcessing($conditions);
        if (!$processing->check($this)) {
            $this->process = false;
        }
    }

    /**
     * Callback to process $input['before']
     *
     * @param array $callbacks
     */
    public function processBefore($callbacks) {
        foreach ($callbacks as $callback) {
            call_user_func_array($callback, array($this));
        }
    }

    /**
     * Callback to process $input['after']
     *
     * @param array $callbacks
     */
    public function processAfter($callbacks) {
        foreach ($callbacks as $callback) {
            call_user_func_array($callback, array($this));
        }
    }

}
