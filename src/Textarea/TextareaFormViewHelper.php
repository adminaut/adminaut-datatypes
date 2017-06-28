<?php

namespace Adminaut\Datatype\Textarea;

use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\FormTextarea;

/**
 * Class TextareaFormViewHelper
 * @package Adminaut\Datatype\Textarea
 */
class TextareaFormViewHelper extends FormTextarea
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

        $elementId = $element->getAttribute('id');

        $editor = $element->getOption('editor');
        $autoSize = $element->getOption('autosize');

        if ('bootstrap' === $editor) {
            $render .= $this->getEditorScriptBootstrapWYSIHTML5($elementId);
        } else if ('ckeditor' === $editor) {
            $render .= $this->getEditorScriptCKEditor($elementId);
        } else if ('tinymce' === $editor) {
            $render .= $this->getEditorScriptTinyMCE($elementId, $autoSize);
        } else {
            // autosize works only when there is no editor
            if (true === $autoSize) {
                $render .= $this->getAutosizeScript($elementId);
            }
        }

        return $render;
    }

    /**
     * @param $elementId
     * @return string
     */
    private function getEditorScriptBootstrapWYSIHTML5($elementId)
    {
        $content = '$("#' . $elementId . '").wysihtml5({
            toolbar: {
                "font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
                "emphasis": true, //Italics, bold, etc. Default true
                "lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
                "html": false, //Button which allows you to edit the generated HTML. Default false
                "link": false, //Button to insert a link. Default true
                "image": false, //Button to insert an image. Default true,
                "color": false, //Button to change color of font  
                "blockquote": false, //Blockquote  
                "size": "none", //default: none, other options are xs, sm, lg,
                "fa": false //use font awesome instead of glyphicons? default false
            }
        });';
        return $this->getScript($content);
    }

    /**
     * @param $elementId
     * @return string
     */
    private function getEditorScriptCKEditor($elementId)
    {
        $content = 'CKEDITOR.replace("' . $elementId . '");';
        return $this->getScript($content);
    }

    /**
     * @param $elementId
     * @param bool $autoSize
     * @return string
     */
    private function getEditorScriptTinyMCE($elementId, $autoSize = false)
    {
        $options = '{
            selector: "#' . $elementId . '"
        }';

        // todo: read more at https://www.tinymce.com/docs/plugins/autoresize/
        if (true === $autoSize) {
            $options = '{
                selector: "#' . $elementId . '", 
                plugins: "autoresize",
                autoresize_bottom_margin: 20,
                autoresize_min_height: 200,
                autoresize_max_height: 500
            }';
        }

        $content = 'tinymce.init(' . $options . ');';

        return $this->getScript($content);
    }

    private function getAutosizeScript($elementId)
    {
        $content = 'autosize($("#' . $elementId . '"));';
        return $this->getScript($content);
    }

    /**
     * @param $content
     * @return string
     */
    private function getScript($content)
    {
        return '<script>$(document).ready(function() {' . $content . '});</script>' . PHP_EOL;
    }
}
