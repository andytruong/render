<?php

namespace AndyTruong\Render\Processing;

class Conditions
{

    private $type = 'and';
    private $conditions;

    public function __construct($conditions)
    {
        $this->setConditions($conditions);
    }

    protected function validateConditions($conditions)
    {
        if (!is_array($conditions)) {
            throw new \Exception('Condition must be array.');
        }

        if (isset($conditions['type'])) {
            if (!in_array($conditions['type'], array('and', 'or', 'xor', 'not'))) {
                throw new \Exception('Invalidate logical operator. Valid: and, or, xor');
            }

            if (!isset($conditions['conditions']) || !is_array($conditions['conditions'])) {
                throw new \Exception('Conditions must be array.');
            }

            foreach ($conditions['conditions'] as $condition) {
                if (!is_callable($condition)) {
                    throw new \Exception('All condition must be callable.');
                }
            }
        }
    }

    public function setConditions($conditions)
    {
        $this->validateConditions($conditions);
        if (!isset($conditions['type'])) {
            $conditions = array('type' => 'and', 'conditions' => $conditions);
            $this->setConditions($conditions);
        }
        else {
            $this->type = $conditions['type'];
            $this->conditions = $conditions['conditions'];
        }
    }

    /**
     *
     * @param \AndyTruong\Render\RenderManager $render_manager
     */
    public function check($render_manager)
    {
        $has_one_true = false;
        $has_one_false = false;

        foreach ($this->conditions as $condition) {
            $result = call_user_func_array($condition, array($render_manager));

            if ('and' === $this->type && !$result) {
                return false;
            }

            if ('or' === $this->type && $result) {
                return true;
            }

            if (('xor' === $this->type) && $result && $has_one_true) {
                return false;
            }

            $result ? ($has_one_true = true) : ($has_one_false = true);
        }

        if ($this->type === 'xor') {
            return $has_one_true;
        }

        if ($this->type === 'or') {
            return !$has_one_false;
        }

        return true;
    }

}
