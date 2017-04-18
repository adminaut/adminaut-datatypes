<?php

namespace Adminaut\Datatype;

use Zend\Form\Element;

/**
 * Class GoogleMap
 * @package Adminaut\Datatype
 */
class GoogleMap extends Element
{
    use Datatype {
        setOptions as datatypeSetOptions;
    }

    /**
     * @var null|string
     */
    protected $longitudeVariable;

    /**
     * @var Element|null
     */
    protected $connectedElement;

    /**
     * @var array
     */
    protected $attributes = [
        'type' => 'datatypeGoogleMap',
    ];

    /**
     * @param  array|\Traversable $options
     * @return self
     */
    public function setOptions($options)
    {
        if(isset($options['longVar'])) {
            $this->setLongitudeVariable($options['longVar']);
        }

        $this->datatypeSetOptions($options);
        return $this;
    }

    /**
     * @return null|string
     */
    public function getLongitudeVariable()
    {
        return $this->longitudeVariable;
    }

    /**
     * @param null|string $longitudeVariable
     */
    public function setLongitudeVariable($longitudeVariable)
    {
        $this->longitudeVariable = $longitudeVariable;
    }

    /**
     * @return null|Element
     */
    public function getConnectedElement()
    {
        return $this->connectedElement;
    }

    /**
     * @param null|Element $connectedElement
     */
    public function setConnectedElement($connectedElement)
    {
        $this->connectedElement = $connectedElement;
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
