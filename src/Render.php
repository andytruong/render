<?php
namespace AndyTruong\Render;

/**
 * @todo SourceMaker must be pluggable.
 */
class Render extends BaseRender {
  public function render($data = NULL) {
    if (!is_null($data)) {
      $this->setData($data);
    }

    return $this->build();
  }

  protected function build() {
    foreach (get_class_methods(get_class($this)) as $method) {
      if ('process' === substr($method, 0, 7)) {
        $return = $this->{$method}();
        if ($this->isProcessed()) {
          return $return;
        }
      }
    }
  }

  protected function processString() {
    if (is_string($this->source)) {
      $this->flagProcessed();
      return $this->source;
    }
  }
}
