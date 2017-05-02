<?php

namespace Adminaut\Datatype;

use Adminaut\Datatype\Location\Exception\InvalidDefaultCenterException;
use Zend\Form\Element;

/**
 * Class GoogleStreetView
 * @package Adminaut\Datatype
 */
class GoogleStreetView extends Element
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
    protected $defaultCenter = null;

    /**
     * @var int
     */
    protected $defaultZoomLevel = null;

    /**
     * @var array
     */
    protected $attributes = [
        'type' => 'datatypeGoogleStreetView',
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

        if(isset($options['default_center'])) {
            $this->setDefaultCenter($options['default_center']);
        }

        if(isset($options['default_zoom'])) {
            $this->setDefaultZoomLevel($options['default_zoom']);
        }

        if(isset($options['default_zoom_level'])) {
            $this->setDefaultZoomLevel($options['default_zoom_level']);
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

    /**
     * @return array
     */
    public function getDefaultCenter()
    {
        return $this->defaultCenter;
    }

    /**
     * @param array $defaultCenter
     */
    public function setDefaultCenter($defaultCenter)
    {
        if(!isset($defaultCenter['latitude']) && !isset($defaultCenter['lat'])) {
            throw new InvalidDefaultCenterException('Missing latitude property.');
        } elseif(!isset($defaultCenter['longitude']) && !isset($defaultCenter['lng'])) {
            throw new InvalidDefaultCenterException('Missing longitude property.');
        } else {
            $defaultCenter['latitude'] = $defaultCenter['lat'];
            $defaultCenter['longitude'] = $defaultCenter['lng'];
            unset($defaultCenter['lat'], $defaultCenter['lng']);
            $this->defaultCenter = $defaultCenter;
        }
    }

    /**
     * @return int
     */
    public function getDefaultZoomLevel()
    {
        return $this->defaultZoomLevel;
    }

    /**
     * @param int $defaultZoomLevel
     */
    public function setDefaultZoomLevel($defaultZoomLevel)
    {
        $this->defaultZoomLevel = $defaultZoomLevel;
    }
}
