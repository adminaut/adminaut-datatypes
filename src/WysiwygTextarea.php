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

    const EDITORS = ['none', 'bootstrap', 'ckeditor'];

    protected $attributes = [
        'type' => 'datatypeWysiwygTextarea',
    ];

    protected $editor = 'none';

    protected $rows = 5;

    /**
     * @param $editor
     */
    public function setEditor($editor)
    {
        if (in_array($editor, self::EDITORS)) {
            $this->editor = $editor;
        }
    }

    /**
     * @param $rows
     */
    public function setRows($rows)
    {
        $this->rows = $rows;
    }

    /**
     * @param array|\Traversable $options
     * @return $this
     */
    public function setOptions($options)
    {
        if (isset($options['editor'])) {
            $this->setEditor($options['editor']);
        }

        if (isset($options['rows'])) {
            $this->setRows($options['rows']);
        }

        $this->datatypeSetOptions($options);
        return $this;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        $this->setAttribute('id', $this->attributes['name']);
        $this->setAttribute('rows', $this->rows);
        return $this->attributes;
    }
}
