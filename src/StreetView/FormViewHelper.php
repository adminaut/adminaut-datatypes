<?php
namespace Adminaut\Datatype\StreetView;

use Adminaut\Datatype\StreetView;
use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\AbstractHelper;

class FormViewHelper extends AbstractHelper
{
    /**
     * Invoke helper as functor
     *
     * Proxies to {@link render()}.
     *
     * @param  ElementInterface|null $element
     * @return string|StreetView
     */
    public function __invoke(ElementInterface $element = null)
    {
        if (! $element) {
            return $this;
        }

        return $this->render($element);
    }

    public function render($datatype) {
        if (! $datatype instanceof StreetView) {
            throw new \Zend\Form\Exception\InvalidArgumentException(sprintf(
                '%s requires that the element is of type Adminaut\Datatype\StreetView',
                __METHOD__
            ));
        }

        $identifier = 'datatype-streetview-' . $datatype->getName();
        $value = method_exists($datatype, 'getEditValue') ? $datatype->getEditValue() : $datatype->getValue();

        $sRender = '<div class="row datatype-streetview" id="'. $identifier .'">';
        $sRender .= '<div class="col-xs-12"><input type="' . ($datatype->isUseHiddenElement() ? 'hidden' : 'text') . '" 
        name="'.$datatype->getName().'" value="'.$datatype->getEditValue().'" placeholder="'.$datatype->getAttribute('placeholder').'" 
        class="form-control" id="'. $identifier .'-input"></div>';
        $sRender .= '</div><div class="row">';
        $sRender .= '<div class="col-xs-12 col-sm-4 no-gutter-right"><div class="datatype-streetview-map" style="margin-top: 15px; min-height: 300px;" id="'. $identifier .'-map"></div></div>';
        $sRender .= '<div class="col-xs-12 col-sm-8 no-gutter-left"><div class="datatype-streetview-panorama" style="margin-top: 15px; min-height: 300px;" id="'. $identifier .'-panorama"></div></div>';
        $sRender .= '</div>';

        $sRender .= '<script>appendScript("'. $this->getView()->basepath('adminaut/js/datatype/streetview.js') .'")</script>';

        return $sRender;
    }
}