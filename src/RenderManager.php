<?php

namespace AndyTruong\Render;

use AndyTruong\Render\Processing\Conditions as ConditionsProcessing;

class RenderManager extends RenderManagerProcessing
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

}
