<?php
namespace Adminaut\Datatype\Location;

use Adminaut\Datatype\Location;
use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\AbstractHelper;

class DetailViewHelper extends AbstractHelper
{
    /**
     * Invoke helper as functor
     *
     * Proxies to {@link render()}.
     *
     * @param  ElementInterface|null $element
     * @return string|Location
     */
    public function __invoke(ElementInterface $element = null)
    {
        if (! $element) {
            return $this;
        }

        return $this->render($element);
    }

    public function render($datatype) {
        if (! $datatype instanceof Location) {
            throw new \Zend\Form\Exception\InvalidArgumentException(sprintf(
                '%s requires that the element is of type Adminaut\Datatype\Location',
                __METHOD__
            ));
        }

        $identifier = 'datatype-location-' . $datatype->getName();
        $value = method_exists($datatype, 'getEditValue') ? $datatype->getEditValue() : $datatype->getValue();

        $attributes = $datatype->getAttributes();
        unset($attributes['type']);
        if($datatype->getLongitudeElement()) {
            $attributes['data-longitude-element'] = true;
            $attributes['data-longitude-element-name'] = $datatype->getLongitudeElement()->getName();
        }

        if($datatype->getGooglePlaceIdElement()) {
            $attributes['data-google-place-id-element'] = true;
            $attributes['data-google-place-id-element-name'] = $datatype->getGooglePlaceIdElement()->getName();
        }

        $attributes['data-value'] = $this->getJsonValue($datatype);
        $attributes['data-readonly'] = true;

        $sRender = '<div class="datatype-location" '.$this->createAttributesString($attributes).'></div>';

        $sRender .= '<script>appendScript("'. $this->getView()->basepath('adminaut/js/datatype/location.js') .'")</script>';

        return $sRender;
    }

    /**
     * @param Location $datatype
     * @return string
     */
    private function getJsonValue($datatype) {
        $value = new \stdClass();

        if($datatype->getLongitudeElement()) {
            if(!empty($datatype->getValue())) {
                $value->latitude = $datatype->getValue();
            }
            if(!empty($datatype->getLongitudeElement()->getValue())) {
                $value->longitude = $datatype->getLongitudeElement()->getValue();
            }
        } elseif(!empty($datatype->getValue())) {
            try {
                $data = json_decode($datatype->getValue());

                if(isset($data->latitude)) {
                    $value->latitude = $data->latitude;
                }

                if(isset($data->longitude)) {
                    $value->longitude = $data->longitude;
                }
            } catch (\Exception $e) {
                $data = explode($datatype->getSeparator(), $datatype->getValue());

                if(sizeof($data) >= 2) {
                    $value->latitude = $data[0];
                    $value->longitude = $data[1];
                }
            }
        }

        if($datatype->getEngine() === $datatype::ENGINE_GOOGLE) {
            if ($datatype->getGooglePlaceIdElement()) {
                $value->googlePlaceId = $datatype->getGooglePlaceIdElement()->getValue();
            } else {
                try {
                    $data = json_decode($datatype->getValue());

                    if(isset($data->googlePlaceId)) {
                        $value->googlePlaceId = $data->googlePlaceId;
                    }
                } catch (\Exception $e) {
                    $data = explode($datatype->getSeparator(), $datatype->getValue());

                    if(sizeof($data) >= 2) {
                        $value->googlePlaceId = $data[2];
                    } elseif(sizeof($data) == 1) {
                        $value->googlePlaceId = $data[0];
                    }
                }
            }
        }

        return json_encode($value);
    }
}