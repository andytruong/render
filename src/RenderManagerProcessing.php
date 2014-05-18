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

    public function processBefore($callbacks) {
        foreach ($callbacks as $callback) {
            call_user_func_array($callback, array($this));
        }
    }

    public function processAfter($callbacks) {
        foreach ($callbacks as $callback) {
            call_user_func_array($callback, array($this));
        }
    }

}
