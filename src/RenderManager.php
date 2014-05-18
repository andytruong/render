<?php

namespace AndyTruong\Render;

use AndyTruong\Render\Processing\Conditions as ConditionsProcessing;

class RenderManager extends RenderManagerProcessing
{

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
     *
     * @var boolean
     */
    protected $process = true;

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

    public function getInput()
    {
        return $this->input;
    }

    public function getOutput()
    {
        if (is_null($this->output)) {
            $this->output = new Output();
        }

        return $this->output;
    }

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
        foreach ($this->input as $key => $value) {
            if (!empty(self::$input_callbacks[$key])) {
                foreach (self::$input_callbacks[$key] as $callback) {
                    if ($this->process) {
                        call_user_func_array($callback, array($value));
                    }
                }
            }
        }

        return (string) $this->getOutput();
    }

}
