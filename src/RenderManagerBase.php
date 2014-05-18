<?php

namespace AndyTruong\Render;

abstract class RenderManagerBase extends RenderManagerSystem
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

}
