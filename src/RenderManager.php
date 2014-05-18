<?php

namespace AndyTruong\Render;

/**
 * @todo SourceMaker must be pluggable.
 */
class RenderManager extends BaseRenderManager
{

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
        $output = $this->getOutput();

        $render_id = $source['type'];
        $render_input = $source['value'];

        if ($render = $this->getRender($render_id)) {
            $arguments = array(); // @todo Implement me
            $output[] = $render->render($render_input, $arguments);
        }
    }

}
