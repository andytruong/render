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
            print_r(array($this->file)); echo "\n";
            include_once $this->file;
        }
    }

    protected function afterBuild()
    {

    }

    protected function build()
    {
        $this->beforeBuild();

        foreach (get_class_methods(get_class($this)) as $method) {
            if ('process' === substr($method, 0, 7)) {
                $return = $this->{$method}();
                if ($this->isProcessed()) {
                    break;
                }
            }
        }

        $this->beforeBuild();

        return $return;
    }

    protected function processString()
    {
        if ('string' === $this->source['type']) {
            $this->flagProcessed();
            return $this->source['value'];
        }
    }

    protected function processCallback()
    {
        if ('callback' === $this->source['type']) {
            $this->flagProcessed();
            return call_user_func($this->source['value']);
        }
    }

}
