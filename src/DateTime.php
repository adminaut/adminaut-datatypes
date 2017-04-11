<?php

namespace Adminaut\Datatype;

use DateTime as PhpDateTime;

/**
 * Class DateTime
 * @package Adminaut\Form\Element
 */
class DateTime extends \Zend\Form\Element\DateTime
{
    use Datatype {
        setOptions as datatypeSetOptions;
    }

    /**
     * @var string
     */
    protected $format = 'Y-m-d H:i:s';

    /**
     * @param array|\Traversable $options
     * @return $this
     */
    public function setOptions($options)
    {
        if (!isset($options['add-on-append'])) {
            $options['add-on-append'] = '<i class="fa fa-calendar"></i>';
        }

        $this->datatypeSetOptions($options);
        parent::setOptions($options);
        return $this;
    }

    /**
     * @param bool|true $returnFormattedValue
     * @return mixed|string
     */
    public function getValue($returnFormattedValue = true)
    {
        $value = parent::getValue();
        if($value === null || (gettype($value) == "object" && ($value->getTimestamp() === false || $value->getTimestamp() === -3600))) {
            return date($this->getFormat());
        }
        if (!$value instanceof \DateTime || !$returnFormattedValue) {
            //$value = new \DateTime($value);
            return $value;
        }
        $format = $this->getFormat();
        return $value->format($format);
    }

    /**
     * @return PhpDateTime
     */
    public function getInsertValue()
    {
        return new \DateTime($this->getValue());
    }

    /**
     * @return mixed
     */
    public function getListedValue()
    {
        $value = new \DateTime($this->getValue());
        return $value->format($this->getFormat());
    }
}