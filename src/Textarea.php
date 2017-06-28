<?php

namespace Adminaut\Datatype;

/**
 * Class Textarea
 * @package Adminaut\Datatype
 */
class Textarea extends \Zend\Form\Element\Textarea implements DatatypeInterface
{
    use Datatype {
        setOptions as datatypeSetOptions;
    }

    /**
     * Available editors
     */
    const EDITOR_NONE = 'none';
    const EDITOR_BOOTSTRAP = 'bootstrap';
    const EDITOR_CKEDITOR = 'ckeditor';
    const EDITOR_TINYMCE = 'tinymce';

    const EDITORS = [self::EDITOR_NONE, self::EDITOR_BOOTSTRAP, self::EDITOR_CKEDITOR, self::EDITOR_TINYMCE];

    protected $attributes = [
        'type' => 'datatypeTextarea',
    ];

    protected $editor = 'none';

    protected $rows = 5;

    protected $autosize = false;

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
     * @param int $rows
     */
    public function setRows($rows)
    {
        $this->rows = $rows;
    }

    /**
     * @param bool $autosize
     */
    public function setAutosize($autosize)
    {
        $this->autosize = $autosize;
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

        if (isset($options['autosize'])) {
            $this->setAutosize($options['autosize']);
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
