<?php

namespace AndyTruong\Render;

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
            throw new \Exception('Input must be an array.');
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
            $this->setInput($input);
        }

        return $this->build();
    }

    protected function build()
    {
        foreach (array_keys(self::$input_callbacks) as $key) {
            if (isset($this->input[$key])) {
                foreach (self::$input_callbacks[$key] as $callback) {
                    if ($this->process) {
                        call_user_func_array($callback, array($this->input[$key]));
                    }
                }
            }
        }

        return (string) $this->getOutput();
    }

}
