<?php

namespace Adminaut\Datatype;
use Traversable;

/**
 * Class Select
 * @package Adminaut\Datatype
 */
class Select extends \Zend\Form\Element\Select
{
    use Datatype {
        setOptions as datatypeSetOptions;
    }

    /**
     * @return mixed
     */
    public function getListedValue()
    {
        return $this->getValue();
    }

    /**
     * @return mixed
     */
    public function getInsertValue()
    {
        return $this->getValue();
    }

    /**
     * @return mixed
     */
    public function getEditValue()
    {
        return $this->getValue();
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        $this->attributes['id'] = $this->attributes['name'];
        return $this->attributes;
    }

    /**
     * @param array|Traversable $options
     * @return \Zend\Form\Element
     */
    public function setOptions($options) {
        return $this->datatypeSetOptions($options);
    }
}
