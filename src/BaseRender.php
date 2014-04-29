<?php
namespace AndyTruong\Render;

abstract class BaseRender {
  /**
   *
   * @var string
   */
  protected $prefix;

  /**
   *
   * @var string
   */
  protected $suffix;

  /**
   *
   * @var array
   */
  protected $conditions;

  /**
   *
   * @var mixed
   */
  protected $source;

  /**
   *
   * @var array
   */
  protected $call_before;

  /**
   *
   * @var array
   */
  protected $call_after;

  /**
   * Flag to know the content is processed.
   *
   * @var boolean
   */
  protected $processed = FALSE;

  /**
   * Wrapper method to set object properties.
   *
   * @param string|array $data
   */
  public function setData($data) {
    if (is_string($data)) {
      return $this->setSource($data);
    }

    foreach (array('prefix', 'suffix', 'conditions', 'source') as $k => $v) {
      if (isset($data[$k])) {
        $method = 'set' . ucfirst($k);
        $this->{$method}($v);
      }
    }
  }

  /**
   * Set source property.
   *
   * @param mixed $source
   */
  public function setSource($source) {
    $this->source = $source;
  }

  /**
   * Set prefix property.
   *
   * @param string $string
   */
  public function setPrefix($string) {
    $this->prefix = $string;
  }

  /**
   * Set suffix property.
   *
   * @param string $string
   */
  public function setSuffix($string) {
    $this->suffix = $string;
  }

  /**
   * Set conditions property.
   *
   * @param array $conditions
   */
  public function setConditions($conditions) {
    $this->conditions = $conditions;
  }

  /**
   * Set call_before property.
   *
   * @param array $calls
   */
  public function setCallBefore($calls) {
    $this->call_before = $calls;
  }

  /**
   * Set call_after property.
   *
   * @param array $calls
   */
  public function setCallAfter($calls) {
    $this->call_after = $calls;
  }

  protected function flagProcessed() {
    $this->processed = TRUE;
  }

  protected function isProcessed() {
    return TRUE === $this->processed;
  }
}
