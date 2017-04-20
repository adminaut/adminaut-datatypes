<?php

namespace Adminaut\Datatype;

use Zend\Form\Element;

/**
 * Class StreetView
 * @package Adminaut\Datatype
 */
class StreetView extends Element
{
    use Datatype {
        setOptions as datatypeSetOptions;
    }

    /**
     * @var bool
     */
    protected $useHiddenElement = false;

    /**
     * @var array
     */
    protected $attributes = [
        'type' => 'datatypeStreetView',
    ];

    /**
     * @param  array|\Traversable $options
     * @return self
     */
    public function setOptions($options)
    {
        if (isset($options['use_hidden_element'])) {
            $this->setUseHiddenElement($options['use_hidden_element']);
        }

        $this->datatypeSetOptions($options);
        return $this;
    }

    /**
     * @return bool
     */
    public function isUseHiddenElement()
    {
        return $this->useHiddenElement;
    }

    /**
     * @param bool $useHiddenElement
     */
    public function setUseHiddenElement($useHiddenElement)
    {
        $this->useHiddenElement = $useHiddenElement;
    }

    /**
     * @param string $separator
     */
    public function setSeparator($separator)
    {
        $this->separator = $separator;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        $this->attributes['id'] = $this->attributes['name'];
        return $this->attributes;
    }

    public function getEditValue()
    {
        return htmlspecialchars($this->getValue());
    }
}
