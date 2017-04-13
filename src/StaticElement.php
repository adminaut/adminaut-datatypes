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
}
