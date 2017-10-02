<?php

namespace Adminaut\Datatype;

use Traversable;

/**
 * Class Text
 * @package Adminaut\Datatype
 */
class StaticElement extends \TwbBundle\Form\Element\StaticElement
{
    use Datatype {
        setOptions as datatypeSetOptions;
    }

    /**
     * @var string
     */
    protected $title;

    /**
     * @param array|Traversable $options
     */
    public function setOptions($options)
    {
        if(isset($options['label'])) {
            $this->title = $options['label'];
            unset($options['label']);
        }

        if(isset($options['title'])) {
            $this->title = $options['title'];
        }

        $this->datatypeSetOptions($options);
    }

    /**
     * todo: temporary show delimiter between sections
     * @return string
     */
    public function getValue()
    {
        return '<h3 class="static-element">' . $this->title . '</h3>';
    }
}
