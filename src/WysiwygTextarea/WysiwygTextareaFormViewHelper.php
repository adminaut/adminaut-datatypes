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

        $editor = $element->getOption('editor');

        switch ($editor) {
            case 'bootstrap':
                $render .= '<script>
$(document).ready(function (){
    $(\'#' . $element->getAttribute('id') . '\').wysihtml5();
});
</script>' . PHP_EOL;
                break;
            case 'ckeditor':
                $render .= '<script>
$(document).ready(function (){
    CKEDITOR.replace(\'' . $element->getAttribute('id') . '\');
});
</script>' . PHP_EOL;
                break;
            case 'tinymce':
                $render .= '<script>
$(document).ready(function (){
    tinymce.init({selector:\'#' . $element->getAttribute('id') . '\'});
});
</script>' . PHP_EOL;
                break;
            case 'none':
            default:
                break;
        }

        return $render;
    }
}
