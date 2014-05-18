<?php

namespace AndyTruong\Render;

/**
 * @todo SourceMaker must be pluggable.
 */
class Render extends BaseRender
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

    protected function beforeBuild()
    {
        if (!is_null($this->file)) {
            include_once $this->file;
        }
    }

    protected function afterBuild()
    {

    }

    protected function build()
    {
        $this->beforeBuild();

        $render_id = $this->source['type'];
        $render_input = $this->source['value'];

        if ($render = $this->getRender($render_id)) {
            $arguments = array(); // @todo Implement me
            return $render->render($render_input, $arguments);
        }

        $this->beforeBuild();

        return $return;
    }

}
