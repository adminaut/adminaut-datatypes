<?php

namespace Adminaut\Datatype;

/**
 * Class WysiwygTextarea
 * @package Adminaut\Datatype
 */
class WysiwygTextarea extends \Zend\Form\Element\Textarea implements DatatypeInterface
{
    use Datatype {
        setOptions as datatypeSetOptions;
    }

    const TYPES = ['bootstrap', 'tinymce'];

    protected $attributes = [
        'type' => 'datatypeWysiwygTextarea',
    ];

    protected $type = 'bootstrap';

    /**
     * @param $type
     */
    public function setType($type)
    {
        if (in_array($type, self::TYPES)) {
            $this->type = $type;
        }
    }

    /**
     * @param array|\Traversable $options
     * @return $this
     */
    public function setOptions($options)
    {
        if (isset($options['type'])) {
            $this->setType($options['type']);
        }

        $this->datatypeSetOptions($options);
        return $this;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        $this->attributes['id'] = $this->attributes['name'];
        return $this->attributes;
    }
}
