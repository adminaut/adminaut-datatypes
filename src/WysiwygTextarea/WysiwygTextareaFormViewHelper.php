<?php

namespace Adminaut\Datatype\WysiwygTextarea;

use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\FormTextarea;

/**
 * Class WysiwygTextareaFormViewHelper
 * @package Adminaut\Datatype\WysiwygTextarea
 */
class WysiwygTextareaFormViewHelper extends FormTextarea
{

    /**
     * @param ElementInterface|null $element
     * @return string
     */
    public function __invoke(ElementInterface $element = null)
    {
        return $this->render($element);
    }

    /**
     * @param ElementInterface $element
     * @return string
     */
    public function render(ElementInterface $element)
    {
        $render = parent::render($element);
        $render .= '<script>$(\'#' . $element->getAttribute('id') . '\').wysihtml5();</script>' . PHP_EOL;
        return $render;
    }
}
